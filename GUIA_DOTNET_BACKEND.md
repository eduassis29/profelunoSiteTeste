# 🔧 Guia para Backend .NET (C#)

Este é um guia para seu amigo que está desenvolvendo em C#/.NET.

---

## 🎯 O que Você Precisa Fazer

Implementar a **API REST que Laravel vai consumir**.

---

## 🏗️ Estrutura Mínima

### Controllers - Endpoints REST

Retornar **JSON**, nunca HTML.

```csharp
[ApiController]
[Route("api/[controller]")]
public class ClassroomsController : ControllerBase
{
    private readonly IClassroomService _service;

    [HttpGet]
    [Authorize]
    public async Task<IActionResult> GetAll()
    {
        var classrooms = await _service.GetAllAsync();
        return Ok(new { success = true, data = classrooms });
    }

    [HttpPost]
    [Authorize]
    public async Task<IActionResult> Create([FromBody] CreateClassroomRequest request)
    {
        var classroom = await _service.CreateAsync(request);
        return CreatedAtAction(nameof(GetAll), new { data = classroom });
    }
}
```

---

## 🔐 Autenticação JWT

```csharp
[HttpPost("login")]
public async Task<IActionResult> Login([FromBody] LoginRequest request)
{
    var user = await _authService.AuthenticateAsync(request.Email, request.Password);
    
    if (user == null)
        return Unauthorized(new { message = "Credenciais inválidas" });

    var token = GenerateJwtToken(user);

    return Ok(new
    {
        success = true,
        token = token,
        user = new
        {
            id = user.Id,
            name = user.Name,
            email = user.Email,
            role = user.Role
        }
    });
}

private string GenerateJwtToken(User user)
{
    var securityKey = new SymmetricSecurityKey(
        Encoding.UTF8.GetBytes(_configuration["Jwt:SecretKey"])
    );
    
    var credentials = new SigningCredentials(securityKey, SecurityAlgorithms.HmacSha256);
    var claims = new[]
    {
        new Claim(ClaimTypes.NameIdentifier, user.Id.ToString()),
        new Claim(ClaimTypes.Email, user.Email),
        new Claim(ClaimTypes.Role, user.Role),
    };

    var token = new JwtSecurityToken(
        issuer: _configuration["Jwt:Issuer"],
        audience: _configuration["Jwt:Audience"],
        claims: claims,
        expires: DateTime.UtcNow.AddHours(24),
        signingCredentials: credentials
    );

    return new JwtSecurityTokenHandler().WriteToken(token);
}
```

---

## 📋 Endpoints Necessários

```
POST   /api/auth/login              - Login
POST   /api/auth/register           - Registrar

GET    /api/classrooms              - Listar salas
POST   /api/classrooms              - Criar sala
GET    /api/classrooms/{id}         - Obter sala
PUT    /api/classrooms/{id}         - Atualizar sala
DELETE /api/classrooms/{id}         - Deletar sala

GET    /api/users                   - Listar usuários
GET    /api/users/me                - Dados do usuário atual
```

---

## ⚙️ appsettings.json

```json
{
  "Jwt": {
    "SecretKey": "sua-chave-super-secreta-com-muitos-caracteres",
    "Issuer": "sua-app",
    "Audience": "sua-api"
  },
  "ConnectionStrings": {
    "DefaultConnection": "Server=.;Database=profeluno;User Id=sa;Password=YourPassword;"
  }
}
```

---

## 🔄 Fluxo de Trabalho

1. Você implementa um endpoint no .NET
2. Testa com Postman
3. Avisa ao seu amigo Laravel que está pronto
4. Ele integra usando `DotNetService`
5. Ele renderiza em uma view

---

**Data:** 11 de fevereiro de 2026
