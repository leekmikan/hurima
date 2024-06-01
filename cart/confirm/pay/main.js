const stripe = Stripe(PUBLIC_KEY);
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