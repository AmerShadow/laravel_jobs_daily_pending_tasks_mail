<h1>List Of Pending Tasks assigned to You</h1>

@foreach ($tasks as $task)
    <h3>{{$task->title}}</h3>
    <p>{{$task->description}}</p>
@endforeach


raw: {{$tasks}}
