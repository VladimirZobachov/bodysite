$(document).ready(function () {
    const screenWidth = window.screen.width;
    const $orderCallForm = $(".ordercallform");
    const $backgroundHide = $orderCallForm.find(".backgroundhide");
    const $errorBot = $orderCallForm.find(".errorbot");
    const $submitBtn = $orderCallForm.find("input[type=submit]");

    initializeViewport();
    initializeFormDisplay();
    initializeRequiredFields();
    initializeAgreementCheck();
    initializePhoneValidation();
    initializeSlider();
    initializeCaptchaVisibility();

    // Viewport meta tag adjustments for mobile screens
    function initializeViewport() {
        if (screenWidth < 600) {
            $("head").append('<meta name="viewport" content="width=500, user-scalable=yes">');
        } else if (screenWidth < 800) {
            $("head").append('<meta name="viewport" content="width=600, user-scalable=yes">');
        }
    }

    // Hide the form elements initially
    function initializeFormDisplay() {
        $backgroundHide.hide();
        $errorBot.hide();

        $(".ordercallink").click(() => showForm());
        $orderCallForm.find(".box_shadow, .close").click(() => hideForm());
    }

    function showForm() {
        $backgroundHide.fadeIn(50);
        $("html").css("overflow", "hidden");
    }

    function hideForm() {
        $backgroundHide.fadeOut(50);
        $("html").css("overflow", "auto");
    }

    // Mark required fields and add listeners for policy agreement
    function initializeRequiredFields() {
        $orderCallForm.find(".message").each(function () {
            $(this).prev().addClass("important empty");
        });
    }

    // Enable/disable submit button based on policy agreement
    function initializeAgreementCheck() {
        const $agreeForm = $orderCallForm.find(".agreeform");
        if ($agreeForm.length) {
            $agreeForm.on("change", function () {
                $submitBtn.prop("disabled", !$agreeForm.is(":checked"));
            });
        } else {
            $submitBtn.prop("disabled", false);
        }
    }

    // Phone validation
    function initializePhoneValidation() {
        const phoneRegex = /^\d[\d() -]{4,14}\d$/;
        const $phoneInput = $orderCallForm.find("input[name=phone]");

        $submitBtn.click(() => handleSubmit());

        function handleSubmit() {
            checkRequiredFields();
            if (!isFormValid()) {
                showValidationMessages();
            } else {
                submitForm();
            }
        }

        function isFormValid() {
            return !$orderCallForm.find(".empty").length && isValidPhone();
        }

        function isValidPhone() {
            const phone = $phoneInput.val();
            return phoneRegex.test(phone);
        }

        function checkRequiredFields() {
            $orderCallForm.find("input[type=text].important").each(function () {
                const $input = $(this);
                if ($input.val()) {
                    $input.removeClass("empty");
                    $input.next(".message").hide();
                } else {
                    $input.addClass("empty");
                }
            });
        }

        function showValidationMessages() {
            $orderCallForm.find(".empty").each(function () {
                const $message = $(this).next(".message");
                $message.text("Это поле обязательное").show();
            });
            if (!isValidPhone() && $phoneInput.val()) {
                $phoneInput.next(".message").text("Введен некорректный номер").show();
            }
        }
    }

    // Submit form via AJAX
    function submitForm() {
        const formData = $(".ordercallsent").serialize();
        $.ajax({
            type: "POST",
            url: "/ordercall/send/", // Update URL as needed
            data: formData,
            dataType: "json",
            success: function (response) {
                handleFormSuccess();
            },
            error: function () {
                handleFormError();
            }
        });
    }

    function handleFormSuccess() {
        $orderCallForm.find(".hideform").hide();
        $orderCallForm.find(".form").css("margin-top", "100px");
        $orderCallForm.find(".headerinfo").text("Форма отправлена успешно");
    }

    function handleFormError() {
        $errorBot.show();
    }

    // Initialize time range slider
    function initializeSlider() {
        const timeOptions = Array.from({ length: 10 }, (_, i) => i + 12);
        const $timeline = $orderCallForm.find(".polzunok");
        const $timeFromInput = $orderCallForm.find("input[name=timefrom]");
        const $timeToInput = $orderCallForm.find("input[name=timeto]");

        $timeline.slider({
            animate: "slow",
            range: true,
            min: 12,
            max: 21,
            step: 1,
            values: [14, 19],
            slide: function (event, ui) {
                $timeFromInput.val(ui.values[0]);
                $timeToInput.val(ui.values[1]);
            }
        });

        $timeFromInput.val($timeline.slider("values", 0));
        $timeToInput.val($timeline.slider("values", 1));

        const $resultTime = $("#resulttime");
        if ($resultTime.length) {
            timeOptions.forEach(time => $resultTime.append(`<div>${time}</div>`));
        }
    }

    // Hide invisible CAPTCHA element
    function initializeCaptchaVisibility() {
        const $captcha = $orderCallForm.find(".wa-captcha .g-recaptcha");
        if ($captcha.length && $captcha.attr("data-size") === "invisible") {
            $captcha.css("height", "0px");
        }
    }
});
