document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("update-voyage-form");
    const optionsInput = document.getElementById("updated-options");
    const totalPriceInput = document.getElementById("updated-total-price"); // Référence au champ du prix total
    const quantityInputs = document.querySelectorAll(".quantity-input");
    const totalPriceElement = document.querySelector(".total h3 span");

    // Mettre à jour les options et le prix total avant de soumettre le formulaire
    form.addEventListener("submit", () => {
        const updatedOptions = Array.from(quantityInputs).map(input => ({
            name: input.dataset.name,
            price: input.dataset.price,
            quantity: input.value
        }));
        optionsInput.value = JSON.stringify(updatedOptions);

        // Mettre à jour le prix total
        totalPriceInput.value = totalPriceElement.textContent.replace(" $", "");
    });
});