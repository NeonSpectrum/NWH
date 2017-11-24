var original = $('table').html();
if (screen.width <= 480) {
  $('table').find('td').unwrap().wrap($('<tr/>'));
}
$(window).on('resize', function () {
  if (screen.width <= 480) {
    $('table').find('td').unwrap().wrap($('<tr/>'));
  } else {
    $('table').html(original);
  }
});