import { useState, useEffect } from 'react'
import axios from 'axios'
import TaskCard from './TaskCard'
import TaskForm from './TaskForm'

function App() {
  // タスクの一覧を管理するstate
  const [tasks, setTasks] = useState([])
  // 読み込み中かどうかを管理するstate
  const [loading, setLoading] = useState(true)

  useEffect(() => {
    // コンポーネントが表示されたときにAPIを叩く
    axios.get('http://localhost/api/tasks')
      .then(res => setTasks(res.data.data))
      .catch(err => console.error('取得失敗:', err))
      .finally(() => setLoading(false))
  }, [])

  // タスクが作成されたら一覧に追加する
  function handleCreated(newTask) {
    setTasks([...tasks, newTask])
  }

  if (loading) return <p>読み込み中...</p>

  return (
    <div>
      {/* 新規作成フォーム */}
      <TaskForm onCreated={handleCreated} />

      {/* タスク一覧 */}
      {tasks.map(task => (
        <TaskCard key={task.id} task={task} />
      ))}
    </div>
  )
}

export default App