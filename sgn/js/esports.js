function fetchEsportsModals() {
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("mainEsportsModals").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("POST", "php/esports_modals_fetch.php", true);
		xmlhttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xmlhttp.send();
}