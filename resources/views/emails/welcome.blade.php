@component('mail::message')
# Welcome to Mindset Boost 24, {{ $user->name ?? 'Friend' }}! 🎉

We’re thrilled to have you on board. By signing up, you’ve taken the first step toward mastering your habits, boosting your focus, and achieving your goals.  

Your free starter resources are ready for you – designed to help you **kickstart your journey immediately**. Whether you’re here to build discipline, improve productivity, or just explore, these tools will give you a head start.

@component('mail::button', ['url' => route('purchases.index')])
Access Your Free Resources
@endcomponent

@component('mail::button', ['url' => route('products.index')])
Browse all products
@endcomponent

Remember, consistency is key. Take small steps every day, track your progress, and watch the transformation happen. We’ll be here cheering you on every step of the way!  

Stay disciplined and focused,  
**The Mindset Boost 24 Team**
@endcomponent
