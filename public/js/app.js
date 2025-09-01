document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById("userMenuBtn");
    const panel = document.getElementById("userMenuPanel");
    const profilePicInput = document.getElementById("profilePicInput");
    let profilePicImg = document.getElementById("profilePicImg");

    if (btn && panel) {
        btn.addEventListener("click", function (e) {
            e.stopPropagation();
            if (panel.style.display === "block") {
                panel.style.display = "none";
                btn.blur();
            } else {
                panel.style.display = "block";
            }
        });

        document.addEventListener("click", function (e) {
            if (!panel.contains(e.target) && e.target !== btn) {
                panel.style.display = "none";
                btn.blur();
            }
        });

        document.addEventListener("keydown", function (e) {
            if (e.key === "Escape" && panel.style.display === "block") {
                panel.style.display = "none";
                btn.blur();
            }
        });
    }

    if (profilePicInput && profilePicImg) {
        profilePicInput.addEventListener("change", function (e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    if (profilePicImg.tagName.toLowerCase() === "span") {
                        const newImg = document.createElement("img");
                        newImg.id = "profilePicImg";
                        newImg.className = "profile-pic-avatar";
                        newImg.alt = "Foto de perfil";
                        newImg.src = e.target.result;
                        profilePicImg.parentNode.replaceChild(
                            newImg,
                            profilePicImg
                        );
                        profilePicImg = newImg;
                    } else {
                        profilePicImg.src = e.target.result;
                    }
                };
                reader.readAsDataURL(this.files[0]);
            }
        });
    }

    const dropdownElementList = document.querySelectorAll('.dropdown-toggle:not(.navbar-nav .dropdown-toggle)');
    dropdownElementList.forEach(dropdownToggleEl => {
        new bootstrap.Dropdown(dropdownToggleEl);
    });
});
