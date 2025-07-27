import $ from 'jquery';
import axios from "axios";
import select2 from "select2"
import zxcvbn from "zxcvbn";
select2();
window.$ = jQuery;



$(function () {
    selectPermission();
    passwordHandler();
});


function selectPermission() {
    // Inisialisasi Select2
    const $permission = $('#select-permission');
    $permission.select2({
        theme: "bootstrap-5",
        width: $( this ).data( 'width' ) ? $( this ).data( 'width' ) : $( this ).hasClass( 'w-100' ) ? '100%' : 'style',
        placeholder: $permission.data('placeholder') || 'Pilih sesuatu...'
    });

    axios.get(location.pathname, {
        headers: {
            'Accept': 'application/json'
        },
    })
        .then(response => {
            const datas = response.data;
            datas.forEach((json) => {
                // Add option baru secara dinamis
                const newOption = new Option(json.name, json.name, false, false);
                $permission.append(newOption)
            })
        })
        .catch(error => {
            console.error(error)
        });


}

function passwordHandler() {
    const passwordStrengthMap = [
        { score: 0, label: 'Terlalu Lemah', barClass: 'bg-grd-info', labelClass: 'text-danger' },
        { score: 1, label: 'Lemah', barClass: 'bg-grd-info', labelClass: 'text-warning' },
        { score: 2, label: 'Cukup', barClass: 'bg-grd-primary', labelClass: 'text-info' },
        { score: 3, label: 'Kuat', barClass: 'bg-blue-error', labelClass: 'text-primary' },
        { score: 4, label: 'Sangat Kuat', barClass: 'bg-grd-success', labelClass: 'text-success' }
    ];

    const $passwordField = $(".password").eq(0);
    const $confirmField = $(".password").eq(1);

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
        const confirmValue = $confirmField.find("input").val();
        const $label = $confirmField.find(".password-strength-label");

        if (!confirmValue) {
            $confirmField.find("input").prop('disabled', false)
            $label
                .text("Ulangi password Anda.")
                .removeClass("text-danger text-success")
                .addClass("text-muted");
            return;
        }

        if (passwordValue === confirmValue) {
            $label
                .text("Password cocok.")
                .removeClass("text-danger text-muted")
                .addClass("text-success");
        } else {
            $label
                .text("Password tidak cocok.")
                .removeClass("text-success text-muted")
                .addClass("text-danger");
        }
    };

    // Event password utama
    $passwordField.find("input").on("input", function () {
        const val = $(this).val();
        const { score } = updateStrengthUI($passwordField, val);

        if (score >= 1) {
            validateConfirmation();
        } else {
            $confirmField.find("input").prop('disabled', true);
            $confirmField.find("input").val('')
            $confirmField.find(".password-strength-label")
                .text("Masukkan ulang password Anda.")
                .removeClass("text-danger text-success")
                .addClass("text-muted");
        }
    });

    const $confirmFieldInput =  $confirmField.find("input");
    $confirmField.find("input").on("input", function () {
        validateConfirmation();
    });

    if ($confirmFieldInput.val().trim() !== "") {
        $confirmFieldInput.prop('disabled', false)
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
