<style>
.welcome_sec01 {
  width : 300px;
  margin: 1% auto;

}
.welcome_sec02 {
  padding : 0;
}
.card-header {
  padding: 0;
}
.welcome_main {
  margin: 1rem auto;
}
.welcome_sec01 .card {
  border: none;
}
</style>

<div class="card welcome_main" style="width: 18rem;">
  <img src="../img/visual.jpg" class="card-img-top" alt="Daihan Music">
</div>

<div class="accordion welcome_sec01" id="return">
  <div class="card">
    <div class="card-header" id="headingOne">
      <h2 class="mb-0">
        <button class="btn btn-outline-info btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
          환불<?=$return_new?>
        </button>
      </h2>
    </div>

    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#return">
      <div class="card-body welcome_sec02">
        <div class="list-group">
          <button type="button" onclick="location.href='../welcome.php?page=return&pg=1'" class="list-group-item list-group-item-action">환불 일지<?=$return_new?></button>
          <button type="button" onclick="location.href='../welcome.php?page=return_insert'" class="list-group-item list-group-item-action">환불 등록</button>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingTwo">
      <h2 class="mb-0">
        <button class="btn btn-outline-info btn-lg btn-block" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
          택배<?=$post_new?>
        </button>
      </h2>
    </div>
    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#return">
      <div class="card-body welcome_sec02">
        <div class="list-group">
          <button type="button" onclick="location.href='../welcome.php?page=post_insert'" class="list-group-item list-group-item-action">택배 신청</button>
          <button type="button" onclick="location.href='../welcome.php?page=post&pg=1'" class="list-group-item list-group-item-action">반품 택배 현황<?=$post_new?></button>
        </div>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-outline-info btn-lg btn-block" type="button" onclick="location.href='../welcome.php?page=mainorder'">
          메인 오더
        </button>
      </h2>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-outline-info btn-lg btn-block" type="button" onclick="location.href='../welcome.php?page=vacation'">
          근무 스케줄
        </button>
      </h2>
    </div>
  </div>
  <div class="card">
    <div class="card-header" id="headingThree">
      <h2 class="mb-0">
        <button class="btn btn-outline-info btn-lg btn-block" type="button" onclick="location.href='../welcome.php?page=board&pg=1'">
          직원 게시판<?=$board_new?>
        </button>
      </h2>
    </div>
  </div>
</div>
