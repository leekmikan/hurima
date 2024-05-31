var stripe = Stripe('pk_test_51Oc661JxkDprX6uJ5z2Y568XkjR4zHZec9iUdZYv6baMlIPpcRptdsQNQ2GRsas7P9OkdUWOaYsFm9YDV70mNiiv00Tzc8eBcZ');
var style = {
    base: {
      fontSize: '40vh',
      backgroundColor: '#D0D0D0',
      color: '#000000',
    }
  };
var elements = stripe.elements();
var card = elements.create('card', {style: style});
card.mount('#card-element');
card.addEventListener('change', function(event) {
    var displayError = document.getElementById('card-errors');
    if (event.error) {
      displayError.textContent = event.error.message;
    } else {
      displayError.textContent = '';
    }
  });
  var form = document.getElementById('payment-form');
  form.addEventListener('submit', function(event) {
    event.preventDefault();
  
    stripe.createToken(card).then(function(result) {
      if (result.error) {
        // エラー表示.
        var errorElement = document.getElementById('card-errors');
        errorElement.textContent = result.error.message;
      } else {
        // トークンをサーバに送信
        stripeTokenHandler(result.token);
      }
    });
  });
  function stripeTokenHandler(token) {
    // tokenをフォームへ包含し送信
    var form = document.getElementById('payment-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.setAttribute('type', 'hidden');
    hiddenInput.setAttribute('name', 'stripeToken');
    hiddenInput.setAttribute('value', token.id);
    form.appendChild(hiddenInput);
  
    // Submit します
    form.submit();
  }