<div class="booknow center-block">
  <div class="booknow-content text-center">
    <form id="frmBookNow" class="form-inline">
        <div class="form-group">
          <label>Check In Date: </label>
          <input class="form-control" type="date" id="txtBookCheckInDate" name="txtBookCheckInDate" onkeypress="return disableKey(event,'number')" required/>
        </div>
        <div class="form-group">
          <label>Check Out Date: </label>
          <input class="form-control" type="date" id="txtBookCheckOutDate" name="txtBookCheckOutDate" onkeypress="return disableKey(event,'number')" required/>
        </div>
        <div class="form-group">
          <label>Adults: </label>
          <input class="form-control" type="number" id="txtBookAdults" name="txtBookAdults" value="0" onkeypress="return disableKey(event,'letter')" min="0" max="10" required/>
        </div>
        <div class="form-group">
          <label>Children: </label>
          <input class="form-control" type="number" id="txtBookChildrens" name="txtBookChildrens"value="0" onkeypress="return disableKey(event,'letter')" min="0" max="10" required/>
        </div>
        <div class="form-group">
          <label></label>
          <button class="btn btn-primary" id="btnBookNow" name="btnBookNow">Book Now</button>
        </div>
    </form>
  </div>
</div>