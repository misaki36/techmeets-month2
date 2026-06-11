// ItemCard コンポーネント
// item というデータを受け取って、1件分の商品を表示する部品

function ItemCard({ item }) {  // { item } = 親から渡されたデータを受け取る
  return (
    <div>
      <h3>{item.name}</h3>   {/* item.name を表示 */}
      <p>¥{item.price}</p>   {/* item.price を表示 */}
    </div>
  )
}

export default ItemCard  // 他のファイルからこのコンポーネントを使えるようにする