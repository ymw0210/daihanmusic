  <div class="row">
   <div class="col-md-2"></div>
   <div class="col-md-8">
    <h2 class="text-center">글 입력하기</h2><p></p>
      <form action="../data/process_board.php?mode=insert" method="post" enctype="multipart/form-data">
        <div class="table table-responsive">
         <table class="table table-striped">
           <tr>
             <td>제목</td>
             <td><input type="text"  class="form-control" name="title" required/></td>
           </tr>
           <tr>
             <td>첨부 파일</td>
             <td><input type="file"  class="form-control" name="fileup"></td>
           </tr>

           <tr>
             <td>비밀번호</td>
             <td><input type="password"  class="form-control" name="password" required/></td>
           </tr>

           <tr>
             <td>글내용</td>
             <td><textarea rows="10" cols="50" class="form-control" name="content"></textarea></td>
           </tr>
           <tr>
             <td colspan="2"  class="text-center">
               <input type="submit" value="등록" class="btn btn-secondary">
               <input type="reset" value="초기화" class="btn btn-secondary">
               <input type="button"  class="btn btn-secondary" onclick="location.href='../welcome.php?page=board&pg=1'" value="목록보기">
             </td>
           </tr>

         </table>
       </div>
     </form>
    </div>
  </div>
