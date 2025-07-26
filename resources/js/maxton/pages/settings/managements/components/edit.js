import $ from 'jquery';
import zxcvbn from "zxcvbn";

window.onload = function (e) {
    const passwordStrengthMap = [
        { score: 0, label: 'Terlalu Lemah', barClass: 'bg-grd-info', labelClass: 'text-danger' },
        { score: 1, label: 'Lemah', barClass: 'bg-grd-info', labelClass: 'text-warning' },
        { score: 2, label: 'Cukup', barClass: 'bg-grd-primary', labelClass: 'text-info' },
        { score: 3, label: 'Kuat', barClass: 'bg-blue-error', labelClass: 'text-primary' },
        { score: 4, label: 'Sangat Kuat', barClass: 'bg-grd-success', labelClass: 'text-success' }
    ];

    const $passwordField = $(".password").eq(0);
    const $currentPasswordField = $(".password").eq(1);

    const updateStrengthUI = ($wrapper, value) => {
        const $progressBar = $wrapper.find('.progress-bar');
        const $label = $wrapper.find('.password-strength-label');

        if (!value) {
            $progressBar.css("width", "2%").removeClass(passwordStrengthMap.map(x => x.barClass).join(" "));
            $label.text("Masukkan password Anda.").removeClass(passwordStrengthMap.map(x => x.labelClass).join(" "));
            return { score: 0 };
        }

        const result = zxcvbn(value);
        const score = result.score;
        const map = passwordStrengthMap[score];

        $progressBar
            .css("width", (score + 1) * 20 + "%")
            .attr("aria-valuenow", (score + 1) * 20)
            .removeClass(passwordStrengthMap.map(x => x.barClass).join(" "))
            .addClass(map.barClass);

        $label
            .text(map.label)
            .removeClass(passwordStrengthMap.map(x => x.labelClass).join(" "))
            .addClass(map.labelClass);

        return { score };
    };


    const validateConfirmation = () => {
        const passwordValue = $passwordField.find("input").val();
        const confirmValue = $currentPasswordField.find("input").val();
        const $label = $currentPasswordField.find(".password-strength-label");

        if (!confirmValue) {
            $currentPasswordField.find("input").prop('disabled', false)
            $label
                .text("Mengganti Password. Membutuhkan Password Saat Ini Pada Akun Ini")
                .removeClass("text-danger text-success")
                .addClass("text-muted");
        }

    };


    const $passwordFieldInput = $passwordField.find('input');
    // Event password utama
    $passwordFieldInput.on("input", function () {
        const val = $(this).val();
        const { score } = updateStrengthUI($passwordField, val);

        if (score >= 3) {
            validateConfirmation();
        } else {
            $currentPasswordField.find("input").val('').prop('disabled', true)
            $currentPasswordField.find(".password-strength-label")
                .text("Harap Isi Password Baru")
                .removeClass("text-danger text-success")
                .addClass("text-muted");
        }
    });

    if ($passwordFieldInput.val().trim() !== "") {
        $passwordFieldInput.trigger("input");
    }



    const $$currentPasswordFieldInput =  $currentPasswordField.find("input");
    // Event konfirmasi
    $$currentPasswordFieldInput.on("input", function () {

    });

    if ($$currentPasswordFieldInput.val().trim() !== "") {
        $$currentPasswordFieldInput.prop('disabled', false)
    }

    // Toggle password
    $(document).on('click', '.toggle-password', function () {
        const $btn = $(this);
        const $input = $btn.siblings('input');
        const $icon = $btn.find('i');
        const isPassword = $input.attr('type') === 'password';

        $input.attr('type', isPassword ? 'text' : 'password');
        $icon.text(isPassword ? 'visibility' : 'visibility_off');
    });
}
