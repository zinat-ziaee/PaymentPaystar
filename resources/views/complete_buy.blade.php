<!DOCTYPE html>
<html>
  <head>
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  </head>
  <body>
    <div>
      <form method="POST" action="https://core.paystar.ir/api/pardakht/payment">
        @CSRF
        <input type="hidden" value="{{$token}}" name="token">
        <button type="submit">تکمیل خرید</button>
      </form>
    </div>
  </body>
</html>