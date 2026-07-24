// タスク1件分を表示するコンポーネント
function TaskCard({ task }) {
  return (
    <div>
      <h3>{task.title}</h3>
      <p>{task.body}</p>
      {/* is_completedが1なら「完了」、0なら「未完了」と表示 */}
      <p>{task.is_completed ? '✅ 完了' : '⬜ 未完了'}</p>
    </div>
  )
}

export default TaskCard