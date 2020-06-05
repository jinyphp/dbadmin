<h1>테이블 수정</h1>

<form name="table" action="/tables/<?= $tablename ?>" method="post">
<div class="form-group">
<label for="tablename">테이블명</label>
<input type="text" name="tablename" value="<?= $tablename ?>" class="form-control" id="tablename" placeholder="테이블명을 입력해 주세요">
</div>

<button type="button" class="btn btn-outline-primary" id="create">수정</button>
</form>