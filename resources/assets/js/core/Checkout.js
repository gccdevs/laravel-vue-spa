let stripe = Stripe(Laravel.StripeKey);
let elements = stripe.elements();

export default {

    charge (card) {
        return elements.create(card);
    }

}
