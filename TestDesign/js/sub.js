var stripe = Stripe('pk_test_Z3ctWJuVAUFJ4b3C5VJxnN5u002lvbMdIJ');
var elements = stripe.elements();

var style = {
  base: {
    color: "#32325d",
    fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
    fontSmoothing: "antialiased",
    fontSize: "16px",
    "::placeholder": {
      color: "#aab7c4"
    }
  },
  invalid: {
    color: "#fa755a",
    iconColor: "#fa755a"
  }
};

var cardElement = elements.create("card", { style: style });
cardElement.mount("#card-element");

cardElement.addEventListener('change', ({error}) => {
  const displayError = document.getElementById('card-errors');
  if (error) {
    displayError.textContent = error.message;
  } else {
    displayError.textContent = '';
  }
});

var mail = document.getElementById('usermail').innerHTML;

var form = document.getElementById('subscription-form');

form.addEventListener('submit', function(event) {
  // We don't want to let default form submission happen here,
  // which would refresh the page.
  event.preventDefault();

  stripe.createPaymentMethod({
    type: 'card',
    card: cardElement,
    billing_details: {
      email: mail,
    },
  }).then(stripePaymentMethodHandler);
});

function stripePaymentMethodHandler(result, email) {
  var mail = document.getElementById('usermail').innerHTML;
  console.log(mail);
  console.log(result.paymentMethod.id);
  if (result.error) {
    // Show error in payment form
  } else {
    // Otherwise send paymentMethod.id to your server
    fetch('/create-customer', {
      method: 'post',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({
        email: mail,
        payment_method: result.paymentMethod.id
      }),
    }).then(function(result) {
     return result.json();
    }).then(function(customer) {
      // The customer has been created
    });
  }
}
