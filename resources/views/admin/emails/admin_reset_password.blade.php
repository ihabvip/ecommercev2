@component('mail::message')
# Reset Password Account
Welcome <b> Mr/Ms : {{$data['data']->name}}</b> <br>

The body of your message.

@component('mail::button', ['url' => aurl('reset/password/'.$data['token'])])
Click Here To Reset Your Password
@endcomponent
OR<br>
<p>Copy This Link 
<a href="{{aurl('reset/password/'.$data['token'])}}">{{aurl('reset/password/'.$data['token'])}}</a></p>
Thanks,<br>
{!! Config::set('app.name','Ecommerce')!!}
{{ config('app.name') }}
@endcomponent
