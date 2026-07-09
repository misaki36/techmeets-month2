<?php

namespace Tests\Unit;

use App\Services\PriceCalculator;
use PHPUnit\Framework\TestCase;

class PriceCalculatorBoundaryTest extends TestCase
{
    private PriceCalculator $calculator;

    // 各テストの前に自動で呼ばれる準備メソッド
    protected function setUp(): void
    {
        parent::setUp();
        $this->calculator = new PriceCalculator();
    }

    // ===== 割引率の境界値テスト =====
    // 有効範囲: 0〜100%
    // 境界値:   0（下限）、100（上限）
    // 直前値:  -1（下限の1つ手前 → 無効）
    // 直後値: 101（上限の1つ超  → 無効）

    // 【境界値】割引率0%（有効範囲の下限ちょうど）→ 価格そのまま
    public function test_discount_at_lower_boundary()
    {
        // 0%割引 → 1000円がそのまま返るはず
        $result = $this->calculator->applyDiscount(1000, 0);
        $this->assertEquals(1000, $result);
    }

    // 【境界値】割引率100%（有効範囲の上限ちょうど）→ 0円
    public function test_discount_at_upper_boundary()
    {
        // 100%割引 → 0円になるはず
        $result = $this->calculator->applyDiscount(1000, 100);
        $this->assertEquals(0, $result);
    }

    // 【直前値】割引率-1%（下限の1つ手前 → 無効）→ 例外
    public function test_discount_below_lower_boundary()
    {
        // -1%は無効な値なので例外が投げられるはず
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->applyDiscount(1000, -1);
    }

    // 【直後値】割引率101%（上限の1つ超 → 無効）→ 例外
    public function test_discount_above_upper_boundary()
    {
        // 101%は無効な値なので例外が投げられるはず
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->applyDiscount(1000, 101);
    }

    // ===== 単価・数量の境界値テスト =====

    // 【境界値】単価0円（下限ちょうど）→ 合計0円
    public function test_calculate_total_with_zero_price()
    {
        // 単価0円は有効 → 合計も0円になるはず
        $result = $this->calculator->calculateTotal(0, 5);
        $this->assertEquals(0, $result);
    }

    // 【境界値】数量0個（下限ちょうど）→ 合計0円
    public function test_calculate_total_with_zero_quantity()
    {
        // 数量0個は有効 → 合計も0円になるはず
        $result = $this->calculator->calculateTotal(100, 0);
        $this->assertEquals(0, $result);
    }

    // 【直前値】単価-1円（下限の1つ手前 → 無効）→ 例外
    public function test_calculate_total_with_negative_price()
    {
        // -1円は無効な値なので例外が投げられるはず
        $this->expectException(\InvalidArgumentException::class);
        $this->calculator->calculateTotal(-1, 5);
    }
}
