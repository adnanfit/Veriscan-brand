<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap');

#veriscan-form-container {
    font-family: 'Poppins', sans-serif;
    width: 50%;
    margin: 20px auto;
    background-color: #C0C0C0;
    border-radius: 20px;
    padding: 25px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
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

#veriscan-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

#veriscan-form h2 {
    color: #FFFFFF;
    font-size: 20px;
    font-weight: 500;
    margin: 0 0 15px;
    text-align: left;
}

.input-with-button {
    position: relative;
    width: 100%;
}

#veriscan-code {
    width: 100%;
    padding: 15px 15px 15px 50px;
    background-color: rgba(255, 255, 255, 0.2);
    border: none;
    border-radius: 10px;
    color: #FFFFFF;
    font-size: 18px;
    font-weight: 300;
    outline: none;
    box-sizing: border-box;
    letter-spacing: 0.5em;
}

#veriscan-code::placeholder {
    color: rgba(255, 255, 255, 0.7);
    letter-spacing: normal;
}

.input-with-button svg {
    position: absolute;
    left: 15px;
    top: 50%;
    transform: translateY(-50%);
}

.veriscan-submit-btn {
    width: 50%;
    background-color: #222222 !important;
    color: #FFFFFF;
    border: none !important;
    border-radius: 10px;
    padding: 20px 15px;
    font-size: 18px;
    font-weight: 500;
    cursor: pointer;
    transition: background-color 0.3s;
    margin: 15px auto 0;
    display: block;
}

.veriscan-submit-btn:hover {
    background-color: #333333 !important;
}

@media (max-width: 1200px) {
    #veriscan-form-container {
        width: 60%;
    }

    .veriscan-submit-btn {
        width: 60%;
    }
}

@media (max-width: 992px) {
    #veriscan-form-container {
        width: 70%;
    }

    .veriscan-submit-btn {
        width: 70%;
    }
}

@media (max-width: 768px) {
    #veriscan-form-container {
        width: 80%;
        padding: 20px;
    }

    .veriscan-submit-btn {
        width: 80%;
    }

    #veriscan-form h2 {
        font-size: 18px;
    }

    #veriscan-code {
        width: 77%;
        font-size: 16px;
    }
}

@media (max-width: 576px) {
    #veriscan-form-container {
        width: 90%;
        padding: 15px;
    }

    .veriscan-submit-btn {
        width: 90%;
        padding: 15px;
        font-size: 16px;
    }

    #veriscan-form h2 {
        font-size: 16px;
    }

    #veriscan-code {
        width: 100%;
        font-size: 14px;
        padding: 12px 12px 12px 40px !important;
    }

    .input-with-button svg {
        width: 20px;
        height: 20px;
        left: 10px;
        margin-right: 10px;
    }
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
</style>
<div id="veriscan-overlay"></div>
<div id="veriscan-form-container" class="form-container">
    <form id="veriscan-form">
        <h2>Enter Product Code</h2>
        <div class="input-with-button">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                    d="M20.5 7.27775L12 12M12 12L3.49997 7.27775M12 12L12 21.5M21 16.0586V7.94145C21 7.5988 21 7.42748 20.9495 7.27468C20.9049 7.13951 20.8318 7.01542 20.7354 6.91073C20.6263 6.7924 20.4766 6.7092 20.177 6.54279L12.777 2.43168C12.4934 2.27412 12.3516 2.19535 12.2015 2.16446C12.0685 2.13713 11.9315 2.13713 11.7986 2.16446C11.6484 2.19535 11.5066 2.27413 11.223 2.43168L3.82297 6.5428C3.52345 6.7092 3.37369 6.7924 3.26463 6.91074C3.16816 7.01543 3.09515 7.13951 3.05048 7.27468C3 7.42748 3 7.5988 3 7.94145V16.0586C3 16.4012 3 16.5725 3.05048 16.7253C3.09515 16.8605 3.16816 16.9846 3.26463 17.0893C3.37369 17.2076 3.52345 17.2908 3.82297 17.4572L11.223 21.5683C11.5066 21.7259 11.6484 21.8047 11.7986 21.8355C11.9315 21.8629 12.0685 21.8629 12.2015 21.8355C12.3516 21.8047 12.4934 21.7259 12.777 21.5683L20.177 17.4572C20.4766 17.2908 20.6263 17.2076 20.7354 17.0893C20.8318 16.9846 20.9049 16.8605 20.9495 16.7253C21 16.5725 21 16.4012 21 16.0586Z"
                    stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <input type="text" id="veriscan-code" name="code" placeholder="x x x x x x" autocomplete="off"
                autocorrect="off" autocapitalize="off" spellcheck="false" required />
        </div>
</div>
<button type="submit" class="veriscan-submit-btn">
    Validate
</button>

<?php
// Keeping the existing elements for overlay, loader, popup, and lightbox
// DO NOT MODIFY ANYTHING BELOW THIS LINE
?>
<img id="veriscan-loader" src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/loader.gif"
    style="display:none;" />
</form>

<div id="veriscan-popup" style="display:none;">
    <div id="veriscan-popup-content"></div>
</div>

<!-- Lightbox structure -->
<div id="lightbox" class="lightbox">
    <span class="close">&times;</span>
    <img id="lightbox-image" src="" alt="Full-size Image">
</div>