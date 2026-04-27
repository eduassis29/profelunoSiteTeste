using backend_dotnet.Configuration;
using backend_dotnet.Models;

AppContext.SetSwitch("Npgsql.EnableLegacyTimestampBehavior", true);

var builder = WebApplication.CreateBuilder(args);

// Configurar string de conexão a partir de variáveis de ambiente (Railway)
var dbHost = Environment.GetEnvironmentVariable("DB_HOST") ?? "localhost";
var dbPort = Environment.GetEnvironmentVariable("DB_PORT") ?? "5432";
var dbDatabase = Environment.GetEnvironmentVariable("DB_DATABASE") ?? "profeluno";
var dbUsername = Environment.GetEnvironmentVariable("DB_USERNAME") ?? "postgres";
var dbPassword = Environment.GetEnvironmentVariable("DB_PASSWORD") ?? "postgres";

var connectionString = $"Host={dbHost};Port={dbPort};Database={dbDatabase};Username={dbUsername};Password={dbPassword};";
builder.Configuration.GetSection("ConnectionStrings")["DefaultConnection"] = connectionString;

builder.Services.AddDatabaseConfiguration(builder.Configuration);

builder.Services.AddInfrastructure();

builder.Services.AddControllers();
builder.Services.AddEndpointsApiExplorer();

// Adicionar Swagger apenas em desenvolvimento
if (builder.Environment.IsDevelopment() || builder.Environment.EnvironmentName == "Development")
{
    builder.Services.AddSwaggerGen();
}

builder.Services.Configure<JitsiOptions>(builder.Configuration.GetSection("Jitsi"));

// Configurar porta dinamicamente (Railway fornece via PORT env var, caso contrário 9000)
var port = Environment.GetEnvironmentVariable("PORT") ?? "9000";
builder.WebHost.UseUrls($"http://+:{port}");

var app = builder.Build();

// Configure the HTTP request pipeline.
if (app.Environment.IsDevelopment())
{
    app.UseSwagger();
    app.UseSwaggerUI(c =>
    {
        c.SwaggerEndpoint("/swagger/v1/swagger.json", "Minha API v1");
        c.RoutePrefix = "swagger";
    });
}

// app.UseHttpsRedirection();

app.UseAuthorization();

app.MapControllers();

app.Run();
