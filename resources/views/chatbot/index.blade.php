@extends('layouts.app')

@section('content')
<div class="card card-primary direct-chat direct-chat-primary" style="height: 100vh; display: flex; flex-direction: column;">
  <div class="card-header">
    <h3 class="card-title"><i class="fas fa-robot"></i> ByteBuddy</h3>
  </div>

  <div class="card-body" style="flex: 1; overflow-y: hidden;">
    <!-- Chat messages -->
    <div id="chat-messages" class="direct-chat-messages" style="height: 90%; overflow-y: auto; padding: 10px;">
      <!-- Messages will be appended here -->
    </div>
  </div>

  <div class="card-footer">
    <form id="chat-form" autocomplete="off" class="d-flex">
      @csrf
      <input
        type="text"
        name="message"
        id="user-message"
        class="form-control"
        placeholder="Type your message..."
        required
        autocomplete="off"
        autofocus
      />
      <button type="submit" class="btn btn-primary ml-2">
        <i class="fas fa-paper-plane"></i>
      </button>
    </form>
  </div>
</div>



<script>
  const chatMessages = document.getElementById('chat-messages');
  const chatForm = document.getElementById('chat-form');
  const messageInput = document.getElementById('user-message');

  // Helper to add message bubble
  function addMessage(text, sender = 'bot') {
    const time = new Date().toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });

    const messageWrapper = document.createElement('div');
    messageWrapper.classList.add('direct-chat-msg');
    if(sender === 'user') {
      messageWrapper.classList.add('right');
    } // else bot message on left by default

    messageWrapper.innerHTML = `
      <div class="direct-chat-infos clearfix">
        <span class="direct-chat-name float-${sender === 'user' ? 'right' : 'left'}">
          ${sender === 'user' ? 'You' : 'Bot'}
        </span>
        <span class="direct-chat-timestamp float-${sender === 'user' ? 'left' : 'right'}">${time}</span>
      </div>
      <div class="direct-chat-text">
        ${text}
      </div>
    `;

    chatMessages.appendChild(messageWrapper);
    chatMessages.scrollTop = chatMessages.scrollHeight;
  }

  chatForm.addEventListener('submit', async function(e) {
    e.preventDefault();
    const message = messageInput.value.trim();
    if (!message) return;

    // Add user message bubble
    addMessage(message, 'user');

    // Clear input & show typing...
    messageInput.value = '';
    messageInput.focus();

    addMessage('Typing...', 'bot');

    try {
      const res = await fetch('/chatbot', {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ message })
      });

      const data = await res.json();

      // Remove the 'Typing...' bubble (last bot message)
      chatMessages.lastElementChild.remove();

      // Add real bot reply
      addMessage(data.reply || 'No reply from model.', 'bot');
    } catch (error) {
      chatMessages.lastElementChild.remove();
      addMessage('Error: Unable to reach chatbot.', 'bot');
    }
  });
</script>
@endsection