document.addEventListener("DOMContentLoaded", () => {
    function updateTotal() {
        let total = 0;
        // Pour chaque option sélectionnée, additionner (prix * quantité)
        document.querySelectorAll(".option-card").forEach(card => {
            const radio = card.querySelector("input[type='radio']");
            const number = card.querySelector("input[type='number']");
            if (radio && number && radio.checked) {
                const prix = parseFloat(card.querySelector("label").textContent.match(/(\d+)/)[0]);
                const quantite = parseInt(number.value, 10) || 0;
                total += prix * quantite;
            }
        });
        document.getElementById("total-price").textContent = total;
    }

    document.querySelectorAll(".option-card input[type='radio'], .option-card input[type='number']").forEach(input => {
        input.addEventListener("input", updateTotal);
        input.addEventListener("change", updateTotal);
    });

    updateTotal();
});