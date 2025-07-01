
// function openEditItemModal(id, productName, stockQuantity) {
//     document.getElementById('editItemInventoryId').value = id;
//     document.getElementById('editItemProductName').value = productName;
//     document.getElementById('editItemQuantity').value = stockQuantity;
//     let modal = new bootstrap.Modal(document.getElementById('editItemModal'));
//     modal.show();
// }

// function openAddItemModal(productId, productName) {
//     document.getElementById('addItemInventoryId').value = productId;
//     document.getElementById('addItemProductName').value = productName;
//     let modal = new bootstrap.Modal(document.getElementById('addItemModal'));
//     modal.show();
// }
function openEditItemModal(id, productName, stockQuantity) {
    document.getElementById('editItemInventoryId').value = id;
    document.getElementById('editItemProductName').value = productName;
    document.getElementById('editItemQuantity').value = stockQuantity;

    let modal = new bootstrap.Modal(document.getElementById('editItemModal'));
    modal.show();
}

function openAddItemModal(id, productName) {
    document.getElementById('addItemInventoryId').value = id;
    document.getElementById('addItemProductName').value = productName;

    let modal = new bootstrap.Modal(document.getElementById('addItemModal'));
    modal.show();
}


