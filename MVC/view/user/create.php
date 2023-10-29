

<main>
    <header>
        <h2>Create {{ customer ? "Customer" : "Staff"}}</h2>
    </header>
{% if error %} 
    <p class="error">{{ error }}</p>
{% endif %}
    <section>
       <form action="{{ path }}user/store" method="post">
        <label>Name
            <input type="text" name="name" value="{{ user.name }}" required>
            <span class="error">{{ errors.name }}</span>
        </label>
        <label>Email
            <input type="email" name="email" value="{{ user.email }}" required>
            <span>{{ errors.email }}</span>
        </label>
        <label>Password(at least 8 car.)
            <input type="password" name="password" required>
            <span class="error">{{ errors.password }}</span>
        </label>
        <label>Address
            <input type="text" name="address" value="{{ user.address }}">
            <span class="error">{{ errors.address }}</span>
        </label>
    {% if staff %}
        <label>N.A.S
            <input type="text" name="nas" required>
            <span class="error">{{ errors.nas }}</span>
        </label>
        <label>Privilege
            <select name="privilege_id">
            {% for privilege in privileges %}
                {% if privilege.id != 3 %}
                    <option value="{{ privilege.id }}" >{{ privilege.privilege }}</option>
                {% endif %}
            {% endfor %}
            </select>
        </label>
    {% elseif customer %}
        <input type="hidden" name="privilege_id" value="3">
    {% endif %}
        <input type="submit" value="create" class="button">
       </form>
    </section>
</main>