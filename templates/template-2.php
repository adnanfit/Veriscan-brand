<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

:root {
    --clr-primary: #f4ea10;
}

body {
    margin: 0;
    padding: 0;
}

#veriscan-form-container {
    font-family: 'Poppins', sans-serif;
    width: 100%;
    max-width: 600px;
    margin: 20px auto;
    padding: 25px;
    text-align: center;
}

#veriscan-form {
    width: 100%;
    max-width: 570px;
    margin: auto;
    padding: 10px;
    position: relative;
}

.verify-inputBox {
    position: relative;
    width: 100%;
    max-width: 570px;
    margin: auto;
    padding: 10px;
}

#veriscan-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    z-index: 997;
}

#veriscan-popup {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background-color: white;
    border-radius: 30px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    z-index: 999;
}

#veriscan-loader {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 500px;
    height: auto;
    z-index: 998;
}

.verify-inputBox:after,
.verify-inputBox:before {
    content: '';
    position: absolute;
    width: 150px;
    height: 70px;
    border-radius: 5px;
    z-index: 0;
}

.verify-inputBox:before {
    right: 0;
    bottom: 0;
    background: linear-gradient(180deg, rgba(244, 235, 16, 0) 0%, var(--clr-primary) 100%);
}

.verify-inputBox:after {
    background: linear-gradient(180deg, var(--clr-primary) 0%, rgba(244, 235, 16, 0) 100%);
    left: 0;
    top: 0;
}

.inputBox {
    border: 3px solid #73358b;
    box-shadow: 0px 0px 80px rgba(100, 46, 124, 0.5);
    border-radius: 5px;
    position: relative;
    z-index: 1;
    background: rgb(255 255 255 / 90%) center no-repeat;
    background-blend-mode: overlay;
}

#veriscan-code {
    border: 0;
    min-height: 60px;
    width: 100%;
    padding: 5px 95px 5px 60px;
    outline: none;
    font-size: 18px;
    background: transparent;
    color: #333333;
}

#veriscan-code::placeholder {
    color: #999999;
}

.search-icon {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
    z-index: 2;
}

.veriscan-submit-btn {
    position: absolute;
    right: 15px;
    min-width: 68px;
    height: 60px;
    border: 0;
    background: var(--clr-primary);
    top: -20px;
    border-radius: 5px;
    box-shadow: 0px 2px 10px rgba(0, 0, 0, 0.2);
    z-index: 2;
    cursor: pointer;
    outline: none;
    /* Remove default focus outline */
    transition: box-shadow 0.3s ease;
    /* Smooth transition for box-shadow */
}

.veriscan-submit-btn:hover,
.veriscan-submit-btn:focus,
.veriscan-submit-btn:active {
    background: var(--clr-primary);
    /* Maintain the same background color */
    box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3);
    /* Slightly enhanced shadow for feedback */
}

.veriscan-submit-btn:after {
    content: '';
    width: 0;
    height: 0;
    border-bottom: 15px solid var(--clr-primary);
    border-right: 10px solid transparent;
    position: absolute;
    top: 3px;
    right: -9px;
    filter: drop-shadow(0px 0px 5px rgba(0, 0, 0, 0.15));
}

@media (max-width: 600px) {
    .form-container {
        width: 100%;
    }

    #veriscan-popup {
        top: auto;
        left: 0;
        bottom: 0;
        transform: none;
        margin: 0;
        width: 100%;
        max-width: none;
        border-radius: 15px;

    }

    #veriscan-code {
        padding: 10px 10px 10px 50px !important;
        font-size: 14px !important;

    }

    #veriscan-loader {
        width: 80%;
        max-width: 300px;
    }

    .input-with-button input {
        padding: 10px 50px 10px 15px;
    }

    .input-with-button button {
        right: 15px;
        width: 12%;
    }

    #veriscan-popup .close-btn {
        font-size: 20px;
    }

    #lightbox {
        width: 100%;
        height: 100%;
        padding: 20px;
        box-sizing: border-box;
    }

    #lightbox img {
        max-width: 100%;
        max-height: 80%;
    }

    #lightbox .close {
        font-size: 30px;
    }

}

@media (max-width: 768px) {
    #veriscan-form-container {
        padding: 15px;
    }

    #veriscan-code {
        font-size: 16px;
    }
}
</style>

<div id="veriscan-overlay"></div>
<div id="veriscan-form-container">
    <form id="veriscan-form">
        <div class="verify-inputBox">
            <div class="inputBox">
                <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                    fill="none">
                    <path
                        d="M9.76337 0H9.7665V0.00140235C12.4616 0.00220369 14.9021 1.12348 16.6681 2.93532C18.4312 4.74455 19.5234 7.24554 19.5252 10.0078H19.5265V10.0144V10.0224H19.5252C19.5242 11.1357 19.3461 12.207 19.0185 13.2061C18.9636 13.3738 18.9062 13.5349 18.8472 13.6887V13.6901C18.5648 14.4234 18.1998 15.1165 17.7638 15.755L23.444 20.9916L23.4475 20.9948L23.4781 21.024L23.4803 21.0262C23.801 21.3393 23.9756 21.7586 23.9977 22.1842C24.0192 22.6049 23.8916 23.0352 23.6112 23.3804L23.609 23.3836L23.5748 23.4242L23.568 23.4312L23.5395 23.4633L23.5363 23.4675C23.2307 23.7965 22.8227 23.9752 22.4074 23.9976C21.9979 24.0198 21.5779 23.8894 21.2412 23.6013L21.2383 23.5991L21.1984 23.5641L21.1928 23.5593L15.3831 18.2035C15.2113 18.3277 15.0359 18.4457 14.8583 18.5571C14.6175 18.7083 14.3681 18.8508 14.1136 18.9808C12.8052 19.6503 11.3267 20.0269 9.76356 20.0269V20.0283H9.76044V20.0269C7.0653 20.0261 4.62446 18.9049 2.85842 17.093C1.09474 15.2838 0.00312503 12.7824 0.0013672 10.021H0V10.0144V10.0112H0.0013672C0.00214846 7.24674 1.09532 4.74314 2.86174 2.93171C4.62563 1.12348 7.06393 0.00320537 9.75692 0.00140235V0H9.76337ZM9.7665 2.24576V2.24716H9.76337H9.75692V2.24576C7.6698 2.24716 5.77798 3.11722 4.40844 4.52137C3.03909 5.92553 2.19006 7.86798 2.18947 10.0114H2.19084V10.0146V10.0212H2.18947C2.19084 12.162 3.0385 14.1014 4.40805 15.5066C5.77701 16.9113 7.67077 17.7822 9.76024 17.7826V17.7812H9.76337H9.76982V17.7826C11.8569 17.7812 13.748 16.9115 15.1179 15.507C16.4873 14.1028 17.3363 12.161 17.3367 10.0178H17.3355V10.0146V10.008H17.3367C17.3355 7.86718 16.4871 5.92673 15.1183 4.52197C13.7493 3.11722 11.8562 2.24636 9.7665 2.24576Z"
                        fill="black" />
                </svg>
                <input type="text" id="veriscan-code" name="code" placeholder="Enter Product Code" autocomplete="off"
                    autocorrect="off" autocapitalize="off" spellcheck="false" required />
                <button type="button" class="veriscan-submit-btn" onclick="verifyProd();">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="40" viewBox="0 0 36 40" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M19.1217 0.794465C21.5963 2.35196 24.2646 3.60553 27.0641 4.52584C29.1414 5.21928 31.343 5.50387 33.5374 5.36264L35.814 5.16402L35.9259 7.35857C36.3432 15.4302 34.9861 22.4436 32.1396 27.9756C29.1778 33.7322 24.6247 37.8901 18.7791 40H17.2591C11.5458 37.9976 7.02666 33.9536 4.02748 28.1254C1.22848 22.6553 -0.206641 15.5897 0.0240645 7.16321L0.0851337 4.99797L2.32773 5.10867C4.76901 5.26068 7.21958 5.01966 9.57799 4.3956C12.1309 3.67994 14.5148 2.49566 16.5975 0.908425L17.8155 0L19.1217 0.794465ZM17.958 6.28409C22.5484 9.07774 26.6943 10.3997 30.2533 10.0936C30.8742 22.1408 26.2329 31.3488 18.0055 34.3215C10.0564 31.5376 5.35743 22.6488 5.70689 9.90151C9.88334 10.1131 13.9851 9.25031 17.958 6.28409ZM15.4406 20.0602C15.7573 20.3195 16.0565 20.598 16.3363 20.8938C17.1821 19.585 18.1195 18.3329 19.1421 17.1461C21.9377 13.9064 21.1031 14.118 24.981 14.118L24.428 14.6911C22.972 16.2584 21.6342 17.9232 20.4245 19.6728C19.0798 21.539 17.8604 23.4857 16.774 25.501L16.4347 26.1229L16.126 25.4912C15.5776 24.3425 14.8836 23.2632 14.0598 22.2776C13.3165 21.3763 12.429 20.5939 11.4304 19.9593C11.9359 18.3671 14.3448 19.1844 15.4237 20.0602H15.4406ZM17.9445 2.5755C23.841 6.1571 29.1642 7.85674 33.7376 7.4595C34.5349 22.9548 28.5705 34.2141 18.0055 38.0334C7.80359 34.455 1.76793 23.5897 2.21577 7.22182C7.57967 7.48881 12.8452 6.37851 17.9445 2.5755Z"
                            fill="black" />
                    </svg>
                </button>
            </div>
        </div>
    </form>
</div>

<img id="veriscan-loader" src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/loader.gif"
    style="display:none;" />

<div id="veriscan-popup" style="display:none;">
    <div id="veriscan-popup-content"></div>
</div>