document.addEventListener("DOMContentLoaded", function () {
    const editIcons = document.querySelectorAll(".edit-icon");

    editIcons.forEach(function (icon) {
        icon.addEventListener("click", function () {
            const input = icon.previousElementSibling;
            if (!input || !input.hasAttribute("readonly")) return;

            const valeuroriginale = input.value;
            input.dataset.valeuroriginale = valeuroriginale;
            input.removeAttribute("readonly");
            input.focus();

            icon.style.display = "none";

            const validerBtn = document.createElement("button");
            validerBtn.textContent = "✓";
            validerBtn.className = "btn-valider";
            validerBtn.type = "button";

            const annulerBtn = document.createElement("button");
            annulerBtn.textContent = "✕";
            annulerBtn.className = "btn-annuler";
            annulerBtn.type = "button";

            validerBtn.addEventListener("click", function () {
                input.setAttribute("readonly", true);
                validerBtn.remove();
                annulerBtn.remove();
                icon.style.display = "inline-block";
            });

            annulerBtn.addEventListener("click", function () {
                input.value = input.dataset.valeuroriginale;
                input.setAttribute("readonly", true);
                validerBtn.remove();
                annulerBtn.remove();
                icon.style.display = "inline-block";
            });

        
            icon.parentNode.insertBefore(validerBtn, icon.nextSibling);
            icon.parentNode.insertBefore(annulerBtn, validerBtn.nextSibling);
        });
    });
});
