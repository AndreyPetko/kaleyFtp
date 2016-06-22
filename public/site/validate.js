







$(document).ready(function(){

jQuery(function($){
 $(".phone").mask("+38 (999) 999-9999");
});

  $('#order-form').validate({
    rules: {
      name: {
        required: true,
      },
      phone: {
        required: true
      },
      email: {
        required: true,
        email:true
      }
    },
    messages: {
      name: {
        required: "Вы не указали имя",
      },
      phone: {
        required : "Вы не указали телефон",
      },
      email: {
        required: "Вы не указали email",
        email: "Введите корректный email"
      }
    },
  });


  $('#add-review').validate({
    rules: {
      name: {
        required: true,
      },
      text: {
        required: true
      },
      comment: {
        required: true
      }
    },
    messages: {
      name: {
        required: "Вы не указали имя",
      },
      text: {
        required : "Введите сообщение",
      },
      comment: {
        required: "Введите сообщение"
      }
    },
  });


  $('#sendmail-form').validate({
    rules: {
      email: {
        required: true,
      }
    },
    messages: {
      email: {
        required: "Укажите email"
      }
    }
  });


  $('#feedback-form').validate({
    rules: {
      name: {
        required:true,
      },
      email: {
        required: true
      },
      comment:  {
        required: true
      }
    },
    messages: {
      name: {
        required: "Укажите имя"
      },
      email: {
        required: "Укажите email"
      },
      comment: {
        required: "Укажите ваше сообщение"
      }
    }
  });


  $('#callback-form').validate({
    rules: {
      name: {
        required: true,
      },
      phone: {
        required: true
      }
    },
    messages: {
      name: {
        required: "Укажите имя"
      },
      phone: {
        required: "Укажите телефон"
      }
    }
  });

  $('#intake-form').validate({
    rules: {
      name: {
        required: true,
      },
      email: {
        required: true
      }
    },
    messages: {
      name: {
        required: "Укажите имя"
      },
      email: {
        required: "Укажите email"
      }
    }
  });


  $('#fast-order-form').validate({
    rules: {
      name: {
        required: true,
      },
      phone: {
        required: true
      }
    },
    messages: {
      name: {
        required: "Укажите имя"
      },
      phone: {
        required: "Укажите телефон"
      }
    }
  });


  


});



