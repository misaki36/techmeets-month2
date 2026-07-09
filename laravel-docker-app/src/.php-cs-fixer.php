<?php

// チェック対象のファイル・フォルダを設定
$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude('vendor')    // vendorフォルダは除外
    ->exclude('storage')   // storageフォルダは除外
    ->exclude('bootstrap/cache');  // キャッシュフォルダは除外

// ルールの設定
return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,  // PSR12という標準的なコーディング規約に従う
        'array_syntax' => ['syntax' => 'short'],  // 配列は [] を使う（古い array() は使わない）
        'ordered_imports' => ['sort_algorithm' => 'alpha'],  // useの並び順をアルファベット順に
        'no_unused_imports' => true,  // 使っていないuseは削除
    ])
    ->setFinder($finder);