var stripe = Stripe('pk_test_TYooMQauvdEDq54NiTphI7jx');
var elements = stripe.elements();

// Custom styling can be passed to options when creating an Element.
// (Note that this demo uses a wider set of styles than the guide below.)
/*var style = {
base: {
  color: '#32325d',
  lineHeight: '24px',
  fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
  fontSmoothing: 'antialiased',
  fontSize: '16px',
  '::placeholder': {
    color: '#aab7c4'
  }
},
invalid: {
  color: '#fa755a',
  iconColor: '#fa755a'
}
};

// Create an instance of the card Element
var card = elements.create('card', {style: style});

// Add an instance of the card Element into the `card-element` <div>
card.mount('#card-element');

// Handle real-time validation errors from the card Element.
card.addEventListener('change', function(event) {
var displayError = document.getElementById('card-errors');
if (event.error) {
  displayError.textContent = event.error.message;
} else {
  displayError.textContent = '';
}
});

// Handle form submission
var form = document.getElementById('payment-form');
form.addEventListener('submit', function(event) {
event.preventDefault();

stripe.createToken(card).then(function(result) {
  if (result.error) {
    // Inform the user if there was an error
    var errorElement = document.getElementById('card-errors');
    errorElement.textContent = result.error.message;
  } else {
    // Send the token to your server
    stripeTokenHandler(result.token);
  }
});
})*/

// Set up Stripe.js and Elements to use in checkout form
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

var mail = document.getElementById('usermail').innerHTML;

console.log(mail);
var cardElement = elements.create("card", { style: style });
cardElement.mount("#card-element");

card.addEventListener('change', function(event) {
  var displayError = document.getElementById('card-errors');
  if (event.error) {
    displayError.textContent = event.error.message;
  } else {
    displayError.textContent = '';
  }
});

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


function stripePaymentMethodHandler(result, mail) {
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
