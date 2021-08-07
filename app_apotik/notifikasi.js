var x = 1;

// function audio() {
//     var audio = new Audio('notif.mp3');
//     audio.play();
// }

function audio() {
    var audio = new Audio('');
    audio.play();
}

function cek() {
    $.ajax({
        url: "cekpesan.php",
        cache: false,
        success: function (msg) {
            $("#notifikasi").html(msg);
        }
    });
    var waktu = setTimeout("cek()", 3000);
}



$(document).ready(function () {
    cek();
    $("#pesan").click(function () {
        $("#loading").show();
        if (x == 1) {
            $("#pesan").css("background-color", "#8fd6fa");
            x = 0;
        } else {
            $("#pesan").css("background-color", "#8fd6fa");
            x = 1;
        }
        $("#info").toggle();
        //ajax untuk menampilkan pesan yang belum terbaca
        $.ajax({
            url: "lihatpesan.php",
            cache: false,
            success: function (msg) {
                $("#loading").hide();
                $("#konten-info").html(msg);
            }
        });

    });
    $("#content").click(function () {
        $("#info").hide();
        $("#pesan").css("background-color", "#4B59a9");
        x = 1;
    });
});


