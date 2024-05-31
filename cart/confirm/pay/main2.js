const stripe = Stripe('pk_test_51Oc661JxkDprX6uJ5z2Y568XkjR4zHZec9iUdZYv6baMlIPpcRptdsQNQ2GRsas7P9OkdUWOaYsFm9YDV70mNiiv00Tzc8eBcZ');
async function init(){
  const {clientSecret} = items;
  elements = stripe.elements({ clientSecret });

  const paymentElementOptions = {
    layout: "tabs",
  };

  const paymentElement = elements.create("payment", paymentElementOptions);
  paymentElement.mount("#payment-element");
}
async function pay(){
const { error } = await stripe.confirmPayment({
    elements,
    confirmParams: {
      // Make sure to change this to your payment completion page
      return_url: "http://localhost/PHP/hurima/cart/confirm/pay/stripe/index.php",
    },
  });
}
init();