let textarea = document.getElementById("msg");
 
  // 入力ごとに呼び出されるイベントを設定
  textarea.addEventListener("input", function() {
 
    // 各行を配列の要素に分ける
    let lines = textarea.value.split("\n");
 
    // 入力行数が制限を超えた場合
    if (lines.length > 10) {
 
      var result = "";
 
      for (var i = 0; i < 10; i++) {
        result += lines[i] + "\n";
      }
 
      textarea.value = result;
    }
  }, false);