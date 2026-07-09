<?php

namespace App\Services;

class PriceCalculator
{
    /**
     * 税込合計金額を計算する
     * 
     * @param int $price 単価
     * @param int $quantity 数量
     * @param float $taxRate 税率（デフォルト10%）
     * @return int 税込合計金額
     */
    public function calculateTotal(int $price, int $quantity, float $taxRate = 0.1): int
    {
        // 負の値は不正な入力なので例外を投げる
        if ($price < 0 || $quantity < 0) {
            throw new \InvalidArgumentException('Price and quantity must be positive');
        }

        // 小計 = 単価 × 数量
        $subtotal = $price * $quantity;

        // 税額 = 小計 × 税率
        $tax = $subtotal * $taxRate;

        // 税込合計（小数点以下切り捨て）
        return (int) ($subtotal + $tax);
    }

    /**
     * 割引後の価格を計算する
     * 
     * @param int $price 元の価格
     * @param int $discountPercent 割引率（0〜100）
     * @return int 割引後の価格
     */
    public function applyDiscount(int $price, int $discountPercent): int
    {
        // 割引率は0〜100の範囲外は不正な入力
        if ($discountPercent < 0 || $discountPercent > 100) {
            throw new \InvalidArgumentException('Discount must be between 0 and 100');
        }

        // 割引後価格 = 元の価格 × (1 - 割引率/100)
        return (int) ($price * (1 - $discountPercent / 100));
    }
}