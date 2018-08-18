$('#upload1').change( function(event) {
    if(event.target.files[0]) {
        carregaimagem("1",event);
    } else {
        remover("1");
    }
});
	
$('#upload2').change( function(event) {
    if(event.target.files[0]){
        carregaimagem(2,event);
    } else {
        remover(2);
    }
});

$('#upload3').change( function(event) {
    if(event.target.files[0]){
        carregaimagem(3,event);
    } else {
        remover(3);
    }
});

$('#remover1').click( function(event) {
    remover(1);
});

$('#remover2').click( function(event) {
    remover(2);
});

$('#remover3').click( function(event) {
    remover(3);
});

function carregaimagem(i, event){
    var path = event.target.files[0].name;
    var tmppath = URL.createObjectURL(event.target.files[0]);
    $("#imager"+i).css("visibility", "visible");
    $("#imager"+i).fadeIn("fast").attr('src',tmppath);
    $("#arquivo"+i).val(path);
    $("#arquivo"+i).attr('title',path);
    $("#remover"+i).attr('disabled', false);
}

function remover(i){
    $("#upload"+i).val("");
    $("#imager"+i).css("visibility", "hidden");
    $("#imager"+i).fadeIn("fast").attr('src',null);
    $("#arquivo"+i).val("");
    $("#arquivo"+i).attr('title','');
    $("#remover"+i).attr('disabled', true);
}

$("#btnFileChoices").click( function(event) {
    $('#divFileChoices').slideToggle();
});

$("#btnFileUpload1").click( function(event) {
    $('#upload1').click();
});

$("#btnFileUpload2").click( function(event) {
    $('#upload2').click();
});

$("#btnFileUpload3").click( function(event) {
    $('#upload3').click();
});

$("#fecharGaleria").click( function(event) {
    $('#divFileChoices').slideToggle();
});