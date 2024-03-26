BX.ready(function(){
    $(".btn-activate").click(async function(){
        let iblockId = $("#iblock-id").val();
        let name = $("#cert-name").val().trim();
        console.log(iblockId);
        data ={
          name:name,
          iblockId:iblockId,
          action: 'activateCert',
        };
        let result = await BX.ajax.runComponentAction("yanovich:certActivateComponent","activateCert",{
            mode: "class",
            data: data
        });
        if(result.data.error!=true) {
            let tr = "<tr><td>" + name + "</td><td>" + (new Date()).toLocaleDateString("ru") + "</td>";
            $("table#cert").find("tbody").append(tr);
        }
        BX.UI.Dialogs.MessageBox.alert(result.data.message, "Актифвация сертификата");
    });
});