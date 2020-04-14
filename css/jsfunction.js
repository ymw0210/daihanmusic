


//삭제
function del_check() {
  var theForm = document.getElementById('order_check');
    if (confirm("정말 삭제하시겠습니까??") == true) { //확인

    theForm.action = "../data/process_mainorder.php?mode=del";
    theForm.submit();

  } else { //취소

    return false;

  }

}

//ok 삽임
function ok_check() {
  var theForm = document.getElementById('order_check');
    if (confirm("저장하시겠습니까?") == true) { //확인

    theForm.action = "../data/process_mainorder.php?mode=ok_check";
    theForm.submit();

  } else { //취소

    return false;

  }

}

//주문 불가
function order_cancel1() {
  var theForm = document.getElementById('order_check');
    if (confirm("저장하시겠습니까?") == true) { //확인

    theForm.action = "../data/process_mainorder.php?mode=order_cancel1";
    theForm.submit();

  } else { //취소

    return false;

  }

}

//주문 취소
function order_cancel2() {
  var theForm = document.getElementById('order_check');
    if (confirm("저장하시겠습니까?") == true) { //확인

    theForm.action = "../data/process_mainorder.php?mode=order_cancel2";
    theForm.submit();

  } else { //취소

    return false;

  }

}

//체크 취소
function ok_cancel() {
  var theForm = document.getElementById('order_check');
  if (confirm("취소하시겠습니까?") == true) { //확인

    theForm.action = "../data/process_mainorder.php?mode=check_cancel";
    theForm.submit();

  } else { //취소

    return false;

  }

}
