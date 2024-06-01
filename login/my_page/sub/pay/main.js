const stripe = Stripe(PUBLIC_KEY);
const options = {
  clientSecret: items['clientSecret'],
};
const elements = stripe.elements(options);
const paymentElementOptions = {
  layout: "tabs",
};

const paymentElement = elements.create("payment", paymentElementOptions);
paymentElement.mount('#payment-element');


const form = document.getElementById('payment-form');

form.addEventListener('submit', async (event) => {
  event.preventDefault();
  const {error} = await stripe.confirmPayment({
    //`Elements` instance that was used to create the Payment Element
    elements,
    confirmParams: {
      return_url: "http://localhost/PHP/hurima/login/my_page/sub/pay/finish/index.php",
    }
  });

  if (error) {
    // This point will only be reached if there is an immediate error when
    // confirming the payment. Show error to your customer (for example, payment
    // details incomplete)
    const messageContainer = document.querySelector('#error-message');
    messageContainer.textContent = error.message;
  } else {
    // Your customer will be redirected to your `return_url`. For some payment
    // methods like iDEAL, your customer will be redirected to an intermediate
    // site first to authorize the payment, then redirected to the `return_url`.
  }
});