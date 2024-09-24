    <style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

#veriscan-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 998;
}

#veriscan-code {
    padding: 28px 40px;
    border-style: solid;
    border-width: 2px 2px 2px 2px;
    border-color: #362FD9;
    border-radius: 500px 500px 500px 500px;
    font-family: "Poppins", sans-serif;
}

.input-with-button {
    position: relative;
    display: inline-block;
    width: 100%;
}

.form-container {
    width: 55%;
    margin: auto;
}

.input-with-button input {
    width: 100%;
    padding: 10px 90px 10px 15px;
    box-sizing: border-box;
    font-size: 16px;
}

.input-with-button {
    position: relative;
    display: inline-block;
    width: 100%;
}

.input-with-button input {
    width: 100%;
    padding: 10px 60px 10px 15px;
    /* Adjust padding to fit the SVG */
    box-sizing: border-box;
    font-size: 16px;
}

.input-with-button button {
    position: absolute;
    right: 22px;
    top: 0;
    height: 100%;
    padding: 0;
    background: none;
    border: none;
    cursor: pointer;
    display: flex;
    width: 8%;
    align-items: center;
}

.input-with-button input::placeholder {
    color: #85CDFD;
    opacity: 1;
}

.input-with-button button img {
    width: 100%;
    height: auto;
}

.form-container {
    width: 55%;
    margin: auto;
}

.veriscan-submit-btn,
.veriscan-submit-btn [type=submit],
.veriscan-submit-btn button {
    background-color: transparent !important;
    border: none;
    padding: 0;
    cursor: pointer;
}

.veriscan-submit-btn:hover {
    background-color: transparent;
    border: none;
    padding: 0;
    cursor: pointer;
    transition: all .3s;
}

#veriscan-submit-btn:focus {
    background-color: transparent;
    outline: none;
}

/* Override background on active (when button is pressed) */
#veriscan-submit-btn:active {
    background-color: transparent;
}
    </style>

    <style>
#veriscan-loader {
    display: none;
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    width: 500px;
    height: auto;
}

#veriscan-loader img {
    width: 100%;
    height: 100%;
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

#veriscan-popup .close-btn {
    background: none;
    border: none;
    font-size: 16px;
    cursor: pointer;
    float: right;
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
            <div class="input-with-button">
                <input type="text" id="veriscan-code" name="code" placeholder="Enter the Product Scratch Code"
                    autocomplete="off" autocorrect="off" autocapitalize="off" spellcheck="false" required />
                <button type="submit" class="veriscan-submit-btn">
                    <img src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/tick.svg" alt="Submit" />
                </button>
            </div>
            <img id="veriscan-loader" src="<?php echo plugin_dir_url(__FILE__); ?>../assets/images/loader.gif"
                style="display:none;" />
        </form>
    </div>
    <div id="veriscan-popup" style="display:none;">
        <div id="veriscan-popup-content"></div>
    </div>

    <!-- Lightbox structure -->
    <div id="lightbox" class="lightbox">
        <span class="close">&times;</span>
        <img id="lightbox-image" src="" alt="Full-size Image">
    </div>