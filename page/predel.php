
<?php
    $id = $_GET["id"];
    $page = $_GET['page'];
    $query = "SELECT password FROM daihan.board WHERE id = '$id'";
    $result =  $db->query($query);
    $row = $result->fetch(PDO::FETCH_ASSOC);
?>

<div class="container">
    <div class="content row">
        <section class="col-10" style="margin:0 auto;">
            <form action="" method="POST" style="text-align: center;">
                <div class="pass_title">
                    삭제를 위해 패스워드를 입력해주세요.
                </div>

                <div class="pass_input">
                    <input type="password" name="password_check" style="margin: 1% auto;" required/>
                    <input type="hidden" name="id" value="<?=$id?>" />
                    <input type="hidden" name="page" value="<?=$page?>" />
                </div>

                <div>
                  <div class="bottom_btn">
                    <button type="submit" class="btn btn-primary" formaction="../data/process_board.php?mode=delete">확인</button>
                    <button type="button" class="btn btn-secondary" onClick="history.back(-1);">뒤로가기</button>
                  </div>
                </div>

            </form>
        </section>
    </div>
</div>
