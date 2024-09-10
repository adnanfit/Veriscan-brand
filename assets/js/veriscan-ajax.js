jQuery(document).ready(function ($) {
  function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
      results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return "";
    return decodeURIComponent(results[2].replace(/\+/g, " "));
  }

  var codeIdParam = getParameterByName("codeId");
  if (codeIdParam) {
    $("#veriscan-code").val(codeIdParam);
    submitForm();
  }

  function getTimeDifference(validationDate) {
    var currentDate = new Date();
    var validatedDate = new Date(validationDate);
    var diffTime = currentDate - validatedDate;

    var diffDays = Math.floor(diffTime / (1000 * 60 * 60 * 24));
    if (diffDays < 30) {
      return `${diffDays} days ago`;
    } else if (diffDays >= 30 && diffDays < 365) {
      var monthsAgo = Math.floor(diffDays / 30);
      return `${monthsAgo} months ago`;
    } else {
      var yearsAgo = Math.floor(diffDays / 365);
      return `${yearsAgo} years ago`;
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

  function submitForm() {
    $("#veriscan-overlay").show();
    $("#veriscan-loader").show();

    var codeId = $("#veriscan-code").val();
    var apiEndpoint = veriscan_ajax_object.api_endpoint;
    var payload = { codeId: codeId };

    $.ajax({
      type: "POST",
      url: apiEndpoint,
      contentType: "application/json; charset=utf-8",
      data: JSON.stringify(payload),
      success: function (response) {
        $("#veriscan-loader").hide();

        var baseUrl = new URL(apiEndpoint).origin;
        var popupContent = "";
        var linkColor, buttonColor;
        if (response.productInfo) {
          var productImg = response.productInfo.productImg
            ? `${baseUrl}/${response.productInfo.productImg}`
            : `${veriscan_ajax_object.pluginUrl}assets/images/empty.jpg`;
        }

        // Determine colors based on response status
        if (response.status === "valid") {
          linkColor = "#079455";
          buttonColor = "#079455";
          var validationTime = response.validationTime;
          var timeDiffMessage = getTimeDifference(validationTime);
          var dateFormat = formatISODateTime(validationTime);
          console.log(productImg, "logs");

          popupContent = `
                    <div class="popup">
                        <div class="popup-content">
                            <div class="img-container" style="margin-top:-22%">
                                <img src="${
                                  veriscan_ajax_object.pluginUrl
                                }assets/images/success.png" alt="Success" />
                            </div>
                            <div class="popup-header">
                                <h2>${response.message}</h2>
                                <p class="header-p">Scan Successful, the product is valid.</p>
                            </div>
                            <div class="popup-body">
                                <div class="product-info">
                                    img src="${productImg}" alt="Product Image" class="product-image">
                                    <div class="product-details">
                                        <h3 class="prod-title" style="text-transform: capitalize;">${
                                          response.productInfo.productName
                                        }</h3>
                                        <p>${
                                          response.productInfo.description
                                            ? response.productInfo.description
                                            : "Description Not Provided"
                                        }</p>
                                    </div>
                                </div>
                                <div class="product-code">Code: <strong>${
                                  response.serialNumber
                                }</strong></div>
                            </div>
                            <div class="COA-btn">
                                <a href="#" class="view-coa-success" style="color: ${linkColor};">View COA →</a>
                            </div>
                            <button class="close-button" style="background-color: ${buttonColor};">Close</button>
                        </div>
                    </div>
                `;
        } else if (response.status === "used") {
          linkColor = "#FF8C39";
          buttonColor = "#FF8C39";
          var validationTime = response.validationTime;
          var timeDiffMessage = getTimeDifference(validationTime);
          var dateFormat = formatISODateTime(validationTime);
          console.log("dataprod", baseUrl, response.productInfo);
          popupContent = `
                    <div class="popup">
                        <div class="popup-content">
                            <div class="img-container">
                                <img src="${
                                  veriscan_ajax_object.pluginUrl
                                }assets/images/warn.png" alt="Warning" />
                            </div>
                            <div class="popup-header">
                                <h2>${response.message}</h2>
                                <p class="header-p">Code was scanned ${timeDiffMessage} on</p>
                                <p class="header-date"><strong>${dateFormat}</strong></p>
                            </div>
                            <div class="popup-body">
                                <div class="product-info">
                                   <img src="${productImg}" alt="Product Image" class="product-image">
                                    <div class="product-details">
                                        <h3 class="prod-title" style="text-transform: capitalize;">${
                                          response.productInfo.productName
                                        }</h3>
                                        <p class="product-dis">${
                                          response.productInfo.description
                                            ? response.productInfo.description
                                            : "Description Not Provided"
                                        }</p>
                                    </div>
                                </div>
                                <div class="product-code">Code: <strong>${
                                  response.serialNumber
                                }</strong></div>
                            </div>
                            <div class="COA-btn">
                                <a href="#" class="view-coa" style="color: ${linkColor};">View COA →</a>
                            </div>
                            <button class="close-button" style="background-color: ${buttonColor};">Close</button>
                        </div>
                    </div>
                `;
        } else {
          linkColor = "#D92D20";
          buttonColor = "#D92D20";

          popupContent = `
                    <div class="popup">
                        <div class="popup-content">
                            <div class="img-container" style="margin-top:-18%">
                                <img src="${veriscan_ajax_object.pluginUrl}assets/images/error.png" alt="Error" />
                            </div>
                            <div class="popup-header">
                                <h2>${response.message}</h2>
                            </div>
                            <div class="popup-error-body">
                                <p>This product is not listed in our database. Please contact the vendor or check that the code below is correct.</p>
                            </div>
                            <div class="error-code">Code: <strong>${codeId}</strong></div>
                            <button class="close-button" style="background-color: ${buttonColor};">Close</button>
                        </div>
                    </div>
                `;
        }

        $("#veriscan-popup-content").html(popupContent);
        $("#veriscan-popup").show();
        $("#veriscan-overlay").show();
      },
    });
  }

  $("#veriscan-form").submit(function (e) {
    e.preventDefault();
    submitForm();
  });

  $(document).on("click", "#veriscan-popup .close-button", function () {
    $("#veriscan-popup").hide();
    $("#veriscan-overlay").hide();
  });

  $(document).on("click", function (e) {
    if (
      !$(e.target).closest("#veriscan-popup").length &&
      $("#veriscan-popup").is(":visible")
    ) {
      $("#veriscan-popup").hide();
      $("#veriscan-overlay").hide();
    }
  });
});
