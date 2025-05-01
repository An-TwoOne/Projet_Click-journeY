document.addEventListener("DOMContentLoaded", () => {
    const quantityInputs = document.querySelectorAll(".quantity-input");
    const totalPriceElement = document.querySelector(".total h3");
    const subtotalElements = document.querySelectorAll(".subtotal");
    const hiddenInputs = document.querySelectorAll(".quantity-hidden");

    // Met à jour les sous-totaux et le prix total
    const updatePrices = () => {
        let totalPrice = 0;

        quantityInputs.forEach((input, index) => {
            const price = parseFloat(input.dataset.price);
            const quantity = parseInt(input.value, 10) || 0;
            const subtotal = price * quantity;

            // Met à jour le sous-total affiché
            subtotalElements[index].textContent = `${subtotal} $`;

            // Met à jour le champ caché pour le formulaire
            if (hiddenInputs[index]) {
                hiddenInputs[index].value = quantity;
            }

            // Ajoute au prix total
            totalPrice += subtotal;
        });

        // Met à jour le prix total affiché
        totalPriceElement.textContent = `Prix total : ${totalPrice} $`;

        // Met à jour le champ caché pour le montant total
        const totalInput = document.querySelector("input[name='montant']");
        if (totalInput) {
            totalInput.value = totalPrice;
        }
    };

    // Ajoute un écouteur d'événement pour chaque champ de quantité
    quantityInputs.forEach((input) => {
        input.addEventListener("input", () => {
            updatePrices();
        });
    });

    // Initialisation des prix au chargement de la page
    updatePrices();
});