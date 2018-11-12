$.prototype.msgRapida = function(){
  var msg = $('<div></div>');
  msg.addClass('alert');
  this.prepend(msg);
  msg.css('display', 'none');

  return {
    timeout : null,
    abrir: function(tipo, mensagem){
      msg.text(mensagem);

      switch (tipo) {
        case 0:
        msg.addClass('alert-danger');
        break;
        case 1:
        msg.addClass('alert-success');
        break;
        case 2:
        msg.addClass('alert-warning');
        break;
      }

      msg.css('display', 'block');

      if(this.timeout != null){
        clearTimeout(this.timeout);
      }

      this.timeout = setTimeout(function(){
        msg.css('display', 'none');
        msg.removeClass('alert-danger');
      }, 3000);

    }
  };
};

function formatData(data){
  return data.replace(/^(\d{4})+\-+(\d{2})+\-+(\d{2})$/, '$3/$2/$1');
}

function formatHora(data){
  return data.replace(/^(\d{2})+\:+(\d{2})+\:+(\d{2})$/, '$1:$2');
}
