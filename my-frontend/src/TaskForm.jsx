import { useState } from 'react'
import axios from 'axios'

// タスク新規作成フォームのコンポーネント
// onCreated = タスク作成後に親に通知する関数
function TaskForm({ onCreated }) {
  // フォームの入力値を管理するstate
  const [title, setTitle] = useState('')
  const [body, setBody] = useState('')

  async function handleSubmit(e) {
    e.preventDefault() // ページリロードを防ぐ

    try {
      // POSTリクエストでLaravelにデータを送信
      const res = await axios.post('http://localhost/api/tasks', { 
  title, 
  body,
  user_id: 3
})
      onCreated(res.data.data) // 作成したタスクを親に渡す
      setTitle('')             // フォームをリセット
      setBody('')
    } catch (err) {
      console.error('登録失敗:', err)
    }
  }

  return (
    <div>
      <h2>タスク追加</h2>
      <div>
        <input
          value={title}
          onChange={e => setTitle(e.target.value)}
          placeholder="タイトル"
        />
        <input
          value={body}
          onChange={e => setBody(e.target.value)}
          placeholder="内容"
        />
        <button onClick={handleSubmit}>登録する</button>
      </div>
    </div>
  )
}

export default TaskForm