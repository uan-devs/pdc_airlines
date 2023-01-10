var URL = "http://127.0.0.1:8000/api/admin/";
var places = []


$(document).ready(function(){


    var message = localStorage.status;
    if(!message){

    }else{
        if(message == "sucesso"){
            $("#modalTarifaSuccess #modal-message").text("Tarifa alterada com sucesso!")
            $("#modalTarifaSuccess").modal('show');
            localStorage.clear();
        }else{
            $("#modalTarifaError #modal-message").text("Erro ao alterar tarifa!")
            $("#modalTarifaError").modal('show');
            localStorage.clear();
        }
    }

$('.free').click(function(e){
    var lugar = $(this).attr('data-id');
    console.log(lugar);
    // alert(lugar)
    var i = 0;
    if((i = places.indexOf(lugar))>=0){
        $(this).removeClass(" selected ");
        $(this).addClass(" free ");
        places.splice(i,1);
        console.log(places);
        console.log(i);
    }
    else{    
        $(this).removeClass(" free ");
        $(this).addClass(" selected ");
        places.push($(this).attr('data-id'));
        console.log(places);
        console.log(i);
    }
});

$('.selected').click(function(e){
    console.log("REMOVING");
    alert("HEY")
    $(this).removeClass(" selected ");
    $(this).addClass(" free ");
});


$('#tarifa').change(function(){
    var tarifa = $('#tarifa').attr('data-price');
    var price = $('option:selected', this).attr('data-price');
    console.log(price)
    $("#preco").val(price); 
    // txtPreco.val(price);
});




    function alterarTarifa()
    {
        var lugares_ = "";
        for (let i = 0; i < places.length; i++) {
            const element = places[i];
            if(i==0)
            {
                lugares_ = lugares_ + places[i]; 
            }else{
                lugares_ = lugares_ + ","+places[i];
            }
        }
        var tarifa = $("#tarifa").val()
        console.log(lugares_);
        console.log(tarifa);
        
        // return;
        $.ajax(
        {
            url: URL+'voos/alterartarifa',
            // url: URL+'/cinemas/'+idCinema+'/salas',
            type: 'post',
            data: {
                id_tarifa: tarifa,
                lugares : lugares_ 
            },
            beforeSend:function()
            {

            },
            success:function(data)
            {
                console.log(data);
                $("#modalAlterarTarifa").modal('hide');
                if(data.status == 'sucesso')
                {
                    console.log(data.status);
                    
                    
                    localStorage.status = "sucesso";
                    window.location.reload();
                }else{
                    

                    console.log(data.status + "not");
                    localStorage.status = "sucesso";
                    window.location.reload();
                }
               
            },
            error:function(data)
            {
                $("#modalTarifaError #modal-message").text("Erro ao alterar tarifa!")
                $("#modalTarifaError").modal('show');
                console.log(data);
            }
        });
    }

    $('#btn-salvarTarifas').click(function(e){
        e.preventDefault()
        alterarTarifa();
    });

});