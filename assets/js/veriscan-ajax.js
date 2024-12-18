jQuery(document).ready(function ($) {
  //   const baseUrl = "https://api.getveriscan.dev";
  const baseUrl = "https://vapeverification-api-dev.falconweb.app";
  //
  //Get Params data
  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return "";
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  //remove params
  function removeUrlParam(param) {
    var url = window.location.href;
    var regex = new RegExp("[?&]" + param + "=([^&#]*)", "i");
    var newUrl = url.replace(regex, function (match, p1) {
      return url.indexOf(match) === 0 ? "?" : "";
    });
    newUrl = newUrl.replace(/[?&]$/, "");
    history.replaceState(null, null, newUrl);
  }

  //Get Code ID
  var codeIdParam = getParameterByName("h");
  var isFromUrl = false;
  if (codeIdParam) {
    isFromUrl = true;
    submitForm(codeIdParam);
  }

  //Get Brand ID
  function checkBrandId() {
    var brandIdFromAjax = veriscan_ajax_object.brandId;
    var brandId = brandIdFromAjax || localStorage.getItem("veriscan_brand_id");

    if (!brandId) {
      alert("Brand ID not found.");
    }
    return brandId;
  }

  //Get Time difference with scaned time and current time
  function getTimeDifference(validationDate) {
    var currentDate = new Date();
    var validatedDate = new Date(validationDate);
    var diffTime = currentDate - validatedDate;

    var diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    var diffHours = Math.floor(
      (diffTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
    );
    var diffMinutes = Math.floor((diffTime % (1000 * 60 * 60)) / (1000 * 60));

    // Helper function to format time difference
    function formatTime(value, unit) {
      return `${value} ${unit}${value > 1 ? "s" : ""} ago`;
    }

    if (diffDays < 1) {
      if (diffHours < 1) {
        return formatTime(diffMinutes, "minute");
      } else {
        return formatTime(diffHours, "hour");
      }
    } else if (diffDays < 30) {
      return formatTime(diffDays, "day");
    } else if (diffDays >= 30 && diffDays < 365) {
      var monthsAgo = Math.floor(diffDays / 30);
      return formatTime(monthsAgo, "month");
    } else {
      var yearsAgo = Math.floor(diffDays / 365);
      return formatTime(yearsAgo, "year");
    }
  }

  //date format change
  function formatISODateTime(isoDate) {
    const dateObject = new Date(isoDate);
    const dateOptions = { year: "numeric", month: "long", day: "numeric" };
    const timeOptions = {
      hour: "numeric",
      minute: "numeric",
      hour12: true,
    };
    const formattedDate = dateObject.toLocaleDateString("en-US", dateOptions);
    const formattedTime = dateObject.toLocaleTimeString("en-US", timeOptions);
    return `${formattedDate}  |  ${formattedTime}`;
  }

  // Lightbox functionality
  function openLightbox(imgSrc) {
    var lightbox = document.getElementById("lightbox");
    var lightboxImage = document.getElementById("lightbox-image");
    lightboxImage.src = imgSrc;
    lightbox.style.display = "flex";
  }

  // Close lightbox when clicking on the close button
  $(document).on("click", "#lightbox .close", function () {
    $("#lightbox").hide();
  });

  // Close lightbox when clicking outside of the image
  $(window).on("click", function (event) {
    if ($(event.target).is("#lightbox")) {
      $("#lightbox").hide();
    }
  });

  var prodImg = undefined;
  function submitForm(codeId, brandId) {
    $("#veriscan-overlay").show();
    $("#veriscan-loader").show();

    var codeId = codeId;
    var brandId = checkBrandId();
    var apiEndpoint = `${baseUrl}/api/v1/codes/validate`;
    var payload = {
      codeId: codeId,
      brandId: brandId,
    };

    $.ajax({
      type: "POST",
      url: apiEndpoint,
      contentType: "application/json; charset=utf-8",
      data: JSON.stringify(payload),
      complete: function (result) {
        const response = result.responseJSON;
        console.log(response);
        $("#veriscan-loader").hide();

        // Use this function to handle success or further processing
        handleResponse(response);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        let popupContent = "";
        let buttonColor = "#D92D20"; // Error color

        if (jqXHR.status === 0) {
          // CORS Error detected
          popupContent = `
            <div class="popup popup.swipe-up">
              <div class="popup-content">
                <div class="img-container" style="margin-top:-23%">
                  <img src="${veriscan_ajax_object.pluginUrl}assets/images/error.png" alt="Error" />
                </div>
                <div class="popup-header">
                  <h2><strong>CORS Error Detected</strong></h2>
                </div>
                <div class="popup-error-body">
                  <p>CORS policy blocked the request. Please check the server configuration or contact admin for support.</p>
                </div>
                <button class="close-button" style="background-color: ${buttonColor};">Close</button>
              </div>
            </div>
          `;
        } else {
          // Handle other errors here
          popupContent = `
            <div class="popup popup.swipe-up">
              <div class="popup-content">
                <div class="img-container" style="margin-top:-23%">
                  <img src="${veriscan_ajax_object.pluginUrl}assets/images/error.png" alt="Error" />
                </div>
                <div class="popup-header">
                  <h2><strong>Error Detected</strong></h2>
                </div>
                <div class="popup-error-body">
                  <p>An unknown error occurred: ${textStatus}</p>
                </div>
                <button class="close-button" style="background-color: ${buttonColor};">Close</button>
              </div>
            </div>
          `;
        }

        // Display the error popup
        $("#veriscan-popup-content").html(popupContent);
        $("#veriscan-popup").show();
        $("#veriscan-overlay").show();
      },
    });

    // Function to handle the response
    function handleResponse(response) {
      let popupContent = "";
      let linkColor,
        buttonColor,
        productImg = "",
        productImgElement = "",
        coaLink = "",
        productName = "",
        validationTime,
        timeDiffMessage,
        dateFormat,
        displayCode,
        productInfoClass = "";

      // Set product image if available
      if (response?.productInfo) {
        productImg = response.productInfo.productImg
          ? `${baseUrl}/${response.productInfo.productImg}`
          : "";
      }

      // Prepare product image element
      productImgElement = productImg
        ? `<img id="prod-img" src="${productImg}" alt="Product Image" class="product-image">`
        : "";
      productInfoClass = productImg ? "" : "centered-product-info";

      // Helper variables for code display and time formatting
      validationTime = response.validationTime;
      timeDiffMessage = getTimeDifference(validationTime);
      dateFormat = formatISODateTime(validationTime);
      displayCode = response.serialNumber || response.code || codeId;

      // Handle different response statuses
      switch (response.status) {
        case "valid":
          linkColor = "#079455";
          buttonColor = "#079455";

          if (response?.productInfo?.coaLink) {
            coaLink = `<a href="${response.productInfo.coaLink}" target="_blank" class="view-coa d-green" style="color: ${linkColor};">
                        View COA <img class="pad-img" src="${veriscan_ajax_object.pluginUrl}assets/images/gIcon.svg" alt="Arrow" style="vertical-align: middle;" />
                      </a>`;
          }

          if (response?.productInfo?.productName) {
            productName = `<h3 class="prod-title" style="text-transform: capitalize;">${response.productInfo.productName}</h3>`;
          }

          popupContent = `
            <div class="popup popup.swipe-up">
              <div class="popup-content">
                <div class="img-container" style="margin-top:-22%">
                  <img src="${
                    veriscan_ajax_object.pluginUrl
                  }assets/images/success.png" alt="Success" />
                </div>
                <div class="popup-header">
                  <h2><strong>Product Valid</strong></h2>
                  <p class="header-p">Scan Successful, the product is valid.</p>
                </div>
                <div class="popup-body">
                  <div class="product-info ${productInfoClass}">
                    ${productImgElement}
                    <div class="product-details">
                      ${productName}
                      <p>${response.productInfo.description || ""}</p>
                    </div>
                  </div>
                  <div class="product-code">
                    <span class="product-code-label">Code: &nbsp;<span class="display-code">${displayCode}</span></span>
                  </div>
                </div>
                <div class="COA-btn">${coaLink}</div>
                <button class="close-button" style="background-color: ${buttonColor};">Close</button>
              </div>
            </div>`;
          break;

        case "used":
          linkColor = "#FF8C39";
          buttonColor = "#FF8C39";

          if (response?.productInfo?.coaLink) {
            coaLink = `<a href="${response.productInfo.coaLink}" class="view-coa o-green" target="_blank" style="color: ${linkColor};">
                        View COA <img class="pad-img" src="${veriscan_ajax_object.pluginUrl}assets/images/oIcon.svg" alt="Arrow" style="vertical-align: middle;" />
                      </a>`;
          }

          if (response?.productInfo?.productName) {
            productName = `<h3 class="prod-title" style="text-transform: capitalize;">${response.productInfo.productName}</h3>`;
          }

          popupContent = `
            <div class="popup">
              <div class="popup-content">
                <div class="img-container img-already">
                  <img src="${
                    veriscan_ajax_object.pluginUrl
                  }assets/images/warn.png" alt="Warning" />
                </div>
                <div class="popup-header">
                  <h2><strong>Code Already Scanned</strong></h2>
                  <p class="header-p">Code was scanned ${timeDiffMessage} on</p>
                  <p class="header-date"><strong>${dateFormat}</strong></p>
                </div>
                <div class="popup-body">
                  <div class="product-info ${productInfoClass}">
                    ${productImgElement}
                    <div class="product-details">
                      ${productName}
                      <p class="product-dis">${
                        response.productInfo.description || ""
                      }</p>
                    </div>
                  </div>
                  <div class="product-code">
                    <span class="product-code-label">Code: <span class="display-code">${displayCode}</span></span>
                  </div>
                </div>
                <div class="COA-btn">${coaLink}</div>
                <button class="close-button" style="background-color: ${buttonColor};">Close</button>
              </div>
            </div>`;
          break;

        case "formatError":
        case "notfound":
          linkColor = "#D92D20";
          buttonColor = "#D92D20";

          popupContent = `
            <div class="popup popup.swipe-up">
              <div class="popup-content">
                <div class="img-container" style="margin-top:-23%">
                  <img src="${veriscan_ajax_object.pluginUrl}assets/images/error.png" alt="Error" />
                </div>
                <div class="popup-header">
                  <h2><strong>Error Detected</strong></h2>
                </div>
                <div class="popup-error-body">
                  <p>${response.message}. Please get the correct ID from the admin to make it work.</p>
                </div>
                <div class="error-code">
                  <span class="product-code-label">Code: <span class="display-code">${codeId}</span></span>
                </div>
                <button class="close-button" style="background-color: ${buttonColor};">Close</button>
              </div>
            </div>`;
          break;

        default:
          linkColor = "#D92D20";
          buttonColor = "#D92D20";

          popupContent = `
            <div class="popup popup.swipe-up">
              <div class="popup-content">
                <div class="img-container" style="margin-top:-23%">
                  <img src="${veriscan_ajax_object.pluginUrl}assets/images/error.png" alt="Error" />
                </div>
                <div class="popup-header">
                  <h2><strong>Invalid Code Detected</strong></h2>
                </div>
                <div class="popup-error-body">
                  <p>This product is not listed in our database. Please contact the vendor or verify the code below.</p>
                </div>
                <div class="error-code">
                  <span class="product-code-label">Code: <span class="display-code">${codeId}</span></span>
                </div>
                <button class="close-button" style="background-color: ${buttonColor};">Close</button>
              </div>
            </div>`;
          break;
      }

      // Update popup content and display it
      $("#veriscan-popup-content").html(popupContent);
      $("#veriscan-popup").show();
      $("#veriscan-overlay").show();
    }
  }
  $("#veriscan-code").on("input", function () {
    var value = $(this).val();
    if (value.length > 12) {
      $(this).val(value.substring(0, 12));
    }
  });

  $("#veriscan-form").submit(function (e) {
    e.preventDefault();
    var codeId = $("#veriscan-code").val();
    isFromUrl = false;
    submitForm(codeId);
  });

  $(document).on("click", "#prod-img", function () {
    openLightbox(prodImg);
  });

  $(document).on("click", "#veriscan-popup .close-button", function () {
    $("#veriscan-popup").hide();
    $("#veriscan-overlay").hide();
    removeUrlParam("codeId");
  });

  // Click event for closing the popup when clicking outside of it
  $(document).on("click", function (e) {
    if (
      !$(e.target).closest("#veriscan-popup").length &&
      $("#veriscan-popup").is(":visible") &&
      !$(e.target).closest("#lightbox").length
    ) {
      $("#veriscan-popup").hide();
      $("#veriscan-overlay").hide();
      removeUrlParam("codeId");
    }
  });
});
