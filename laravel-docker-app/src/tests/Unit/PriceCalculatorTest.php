<?php

namespace Tests\Unit;

use App\Services\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorTest extends TestCase
{
    // テスト対象のクラスを入れる変数
    private PriceCalculator $calculator;

    // 各テストメソッドの前に自動で呼ばれる準備メソッド
    protected function setUp(): void
    {
        parent::setUp();
        // PriceCalculatorのインスタンスを作成（毎回新しく作る）
        $this->calculator = new PriceCalculator();
    }

    // ===== calculateTotal のテスト =====

    // 【正常系】税率0%のとき、単価×数量がそのまま返るか
    public function test_calculate_total_without_tax()
    {
        // ①Arrange（準備）: 入力値を用意
        $price    = 100;
        $quantity = 2;
        $taxRate  = 0;

        // ②Act（実行）: メソッドを呼ぶ
        $result = $this->calculator->calculateTotal($price, $quantity, $taxRate);

        // ③Assert（検証）: 期待値と一致するか確認
        $this->assertEquals(200, $result); // 100 × 2 = 200
    }

    // 【正常系】税率10%のとき、税込合計が正しく計算されるか
    public function test_calculate_total_with_tax()
    {
        // ①Arrange
        $price    = 100;
        $quantity = 2;
        $taxRate  = 0.1;

        // ②Act
        $result = $this->calculator->calculateTotal($price, $quantity, $taxRate);

        // ③Assert: 100 × 2 = 200、税込 200 × 1.1 = 220
        $this->assertEquals(220, $result);
    }

    // 【異常系】単価が負の数のとき、例外が投げられるか
    public function test_calculate_total_throws_exception_for_negative_price()
    {
        // 次のコードが InvalidArgumentException を投げることを期待
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Price and quantity must be positive');

        // ②Act: 負の単価を渡す → 例外が発生するはず
        $this->calculator->calculateTotal(-100, 2);
    }

    // ===== applyDiscount のテスト =====

    // 【正常系】20%割引で1000円 → 800円になるか
    public function test_apply_discount()
    {
        // ①Arrange
        $price           = 1000;
        $discountPercent = 20;

        // ②Act
        $result = $this->calculator->applyDiscount($price, $discountPercent);

        // ③Assert: 1000 × (1 - 20/100) = 800
        $this->assertEquals(800, $result);
    }

    // 【異常系】150%という無効な割引率で例外が投げられるか
    public function test_apply_discount_throws_exception_for_invalid_percent()
    {
        // 次のコードが InvalidArgumentException を投げることを期待
        $this->expectException(\InvalidArgumentException::class);

        // ②Act: 100を超える割引率を渡す → 例外が発生するはず
        $this->calculator->applyDiscount(1000, 150);
    }
}
