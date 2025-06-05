/* Aqui é o que esconde os campos do formulario de Data */
$("#selecionar").change(function() {
    var $this, secao, secao1, atual, atual1, campos, campos1;
  
    campos = $("div[data-name]");
    campos1 = $("div[data-bs-dismiss]");
    
    campos.removeClass("hide");
    campos1.addClass("show");

    if (this.value !== "") {
        secao = $('option[data-section][value="' + this.value + '"]', this).attr("data-section");
        secao1 = $('option[data-section][value="' + this.value + '"]', this).attr("data-section");
      
        atual = campos.filter("[data-name=" + secao + "]");
        atual1 = campos1.filter("[data-bs-dismiss=" + secao1 + "]");
      
        if (atual !== 0) {
            atual.addClass("hide");
            
        }
        if (atual1 !== 0) {
            atual1.removeClass("show");
        }
    }
});
