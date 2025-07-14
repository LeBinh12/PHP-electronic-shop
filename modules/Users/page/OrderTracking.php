<?php
$address = "Trường Đại Học Đồng Tháp";
?>

<div class="map-container">
    <div class="map-header">
        <h2 class="text-primary">📍 Vị trí đơn hàng của bạn</h2>
        <div class="address-info">
            Địa chỉ: <strong><?= htmlspecialchars($address) ?></strong>
        </div>
    </div>

    <div id="map"></div>
</div>


<script>
    const address = <?= json_encode($address) ?>;

    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
        .then(response => response.json())
        .then(data => {
            if (data && data.length > 0) {
                const lat = parseFloat(data[0].lat);
                const lon = parseFloat(data[0].lon);

                // Hiển thị bản đồ
                const map = L.map('map').setView([lat, lon], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                L.marker([lat, lon]).addTo(map)
                    .bindPopup(address)
                    .openPopup();
            } else {
                alert("Không tìm thấy vị trí cho địa chỉ: " + address);
            }
        })
        .catch(error => {
            console.error("Lỗi khi gọi API Nominatim:", error);
        });
</script>