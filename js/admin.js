$(document).ready(function(e){
  var form = $('#replace_pass_form');
  var old_pass = $('input[name="old_pass"]');
  var new_pass = $('input[name="new_pass"]');
  var new_repass = $('input[name="new_repass"]');
  var replace_pass = $('input[name="replase_pass"]');
  var pass_gen = $('#pass_gen');
  var errors_place = $('#pass_errors');

  function old_pass_is_ready()
  {
    var result;

    $.ajax({
      method: "POST",
      async: false,
      url: "/application/ajax/check_password.php",
      data: "pass=" + old_pass.val(),
      success: function(responce)
      {
        if(responce === 'true')
        {
          result = '-Старый пароль неверен.<br/><br/>';
        }
        else
        {
          result = true;
        }
      }
    });
    return result;
  }

  function new_pass_is_ready()
  {
    var regular = /^[A-z0-9_-]{6,18}$/;
    if(!regular.test(new_pass.val()))
    {
      return '-Новый пароль долен содержать от 6 до 18, букв латинского алфавита, цифр, нижних подчёркиваний или дефисов.</br></br>';
    }
    else
    {
      return true;
    }
  }

  function new_repass_is_ready()
  {
    var regular = /^[A-z0-9_-]{6,18}$/;
    if(new_pass.val() != new_repass.val())
    {
      return '-Поля "Новый пароль" и "Повтор нового пароля" должны совпадать.<br/><br/>';
    }
    else
    {
      return true;
    }
  }

  replace_pass.click(function(e)
  {
    if(old_pass_is_ready() == true && new_pass_is_ready() == true && new_repass_is_ready() == true)
    {
      old_pass.css('border', '');
      new_pass.css('border', '');
      new_repass.css('border', '');
      form.submit();
    }
    else
    {
      var msg = '';
      if(old_pass_is_ready() != true)
      {
        msg += old_pass_is_ready();
        old_pass.css('borderColor', '#FF0000');
      }
      else
      {
        old_pass.css('borderColor', '');
      }
      if(new_pass_is_ready() != true)
      {
        msg += new_pass_is_ready();
        new_pass.css('borderColor', '#FF0000');
      }
      else
      {
        new_pass.css('borderColor', '');
      }
      if(new_repass_is_ready() != true)
      {
        msg += new_repass_is_ready();
        new_repass.css('borderColor', '#FF0000');
      }
      else
      {
        new_repass.css('borderColor', '');
      }
      errors_place.html('<h3 class="med">' + msg.substring(0, msg.lastIndexOf('<br/><br/>')) + '</h3>');
      e.preventDefault();
    }
  });

  pass_gen.click(function(){
    var result = '';
    var words  = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    var max_position = words.length - 1;
        for( i = 0; i < 8; ++i ) {
            position = Math.floor ( Math.random() * max_position );
            result = result + words.substring(position, position + 1);
        }
    new_pass.attr('type', 'text');
    new_pass.val(result);
  });
});
