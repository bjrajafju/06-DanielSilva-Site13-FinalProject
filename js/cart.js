$(document).ready(function () {
    // Atualizar quantidade
    $('.cart-qty').on('input', function () {
        const row = $(this).closest('tr');
        const cartItemId = row.data('cart-item-id');
        const quantity = parseInt($(this).val());

        if (quantity < 1 || isNaN(quantity)) {
            $(this).val(1);
            return;
        }

        $.ajax({
            url: 'cart_update.php',
            method: 'POST',
            data: {
                cart_item_id: cartItemId,
                quantity: quantity
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    row.find('.item-total').text(response.item_total);
                    $('.cart-subtotal').text(response.cart_subtotal);
                    $('.cart-total').text(response.cart_total);
                } else {
                    alert('Erro ao atualizar quantidade.');
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor.');
            }
        });
    });

    // Remover item
    $('.cart-remove').on('click', function () {
        if (!confirm('Deseja remover este item do carrinho?')) return;

        const row = $(this).closest('tr');
        const cartItemId = row.data('cart-item-id');

        $.ajax({
            url: 'cart_remove.php',
            method: 'POST',
            data: {
                cart_item_id: cartItemId
            },
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    row.fadeOut(300, function () {
                        $(this).remove();
                        $('.cart-subtotal').text(response.cart_subtotal);
                        $('.cart-total').text(response.cart_total);

                        // Se o carrinho ficar vazio, recarrega para mostrar a mensagem
                        if ($('tbody tr').length === 0) {
                            location.reload();
                        }
                    });
                } else {
                    alert('Erro ao remover item.');
                }
            },
            error: function () {
                alert('Erro na comunicação com o servidor.');
            }
        });
    });
});
