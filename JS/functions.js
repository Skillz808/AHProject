function redirectToProductPage(id) {
    window.location.href = 'product.php?id=' + id;
  }

function standby() {
    document.getElementById('productImage').src = './Images/ProductImages/default.jpg'
}