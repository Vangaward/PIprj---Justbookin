document.addEventListener("DOMContentLoaded", function () {
    var scrollContainer = document.querySelector('.divDivisor');

    scrollContainer.addEventListener('mousemove', function (e) {
        if (e.buttons === 1) { // Verifica se o botão do mouse está pressionado (botão esquerdo)
            scrollContainer.scrollLeft += e.movementX; // Move a barra de rolagem horizontal com o movimento do mouse
        }
    });
});
/**/
document.getElementById('idTopLits').addEventListener('wheel', function(event) {
    if (event.deltaY !== 0) {
        // Se a roda do mouse rolar verticalmente, não faz nada
        return;
    }

    // Se a roda do mouse rolar horizontalmente
    this.scrollLeft += event.deltaX;
    event.preventDefault();
});