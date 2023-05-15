<!DOCTYPE html>
<html>
  <head></head>
  <body>
    <div>
      <form method="POST" action="{{route('payment.create')}}">
        @CSRF
        <h4>5000ریال</h4>
        <button type="submit">خرید</button>
      </form>
    </div>
  </body>
</html>