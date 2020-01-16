<form action="{{ route('donation.update')  }}" method="POST">
    {{ csrf_field() }}
    <br>
    <h1>建堂奉献金额更新</h1>
    <br>
    <div class="form-group">
        @if (session('duplicate'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> Transaction Duplicated!
            </div>
        @endif
        @if (session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check"></i>Transaction Success!
            </div>
        @endif
            @if (session('error'))
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-triangle"></i> Amount Incorrect!
                </div>
            @endif
        <label>Total Number <span style="color: red">*</span></label>
        <input class="form-control" name="number" placeholder="磚塊總數" type="number" required>
        <input class="form-control" name="hotpot" placeholder="磚塊總數(leave it)" type="hidden">
        @if ($errors->has('number'))
            <span class="help-block">
                <p class="text-danger">Incorrect number entered</p>
            </span>
        @endif
    </div>
    <button type="submit" class="btn btn-primary">提交</button>
</form>