require('./bootstrap');

import Swal from "sweetalert2";

document.addEventListener("DOMContentLoaded", function () {
    //const deleteButtons = document.querySelectorAll(".delete-button");
    const deleteForm = document.querySelectorAll(".delete-form");

    deleteForm.forEach((_form) => {
        _form.addEventListener("submit", function (e) {
            e.preventDefault();

            Swal.fire({
                title: "Confirm Submission",
                text: "Are you sure you want to submit this form?",
                icon: "question",
                showCancelButton: true,
                confirmButtonText: "Yes, submit it!",
                cancelButtonText: "Cancel",
            }).then((result) => {
                if (result.isConfirmed) {
                    _form.submit();
                } else {
                    return false;
                }
            });
        });
    });
});
