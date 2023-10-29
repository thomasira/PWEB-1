

<main>
    <section>
        {% if error %} 
        <p class="error">{{ error }}</p>
        {% endif %}
        {% if success %} 
        <p class="success">{{ success }}</p>
        {% endif %}
        <h2>Login</h2>
        <form action="{{ path }}login/auth" method="post">
            <label>Email
                <input type="email" name="email" required>
            </label>
            <label>Password:
                <input type="password" name="password" required>
            </label>
            <input type="submit" value="login" class="button">
        </form>
    </section>

    <section>
        <h2>Create account</h2>
        <form action="{{ path }}user/store" method="post">
            <label>Name:
                <input type="text" name="name" value="{{ user.name }}" required>
                <span class="error">{{ errors.name }}</span>
            </label>
            <label>Address:
                <input type="text" name="address" value="{{ user.address }}">
                <span class="error">{{ errors.address }}</span>
            </label>
            <label>Email:
                <input type="text" name="email" placeholder="valid email address" value="{{ user.email }}" required>
                <span class="error">{{ errors.email }}</span>
            </label>
            <label>Password:
                <input type="password" name="password" placeholder="6-20 char.(A-z AND 0-9)" minlength="8" required>
                <span class="error">{{ errors.password }}</span>
            </label>
            <input type="hidden" name="privilege_id" value="3">
            <input type="submit" value="create" class="button">
        </form>
    </section>
</main>
    