def listar_fibonacci_20():
    fib = [0, 1]
    for _ in range(2, 20):
        fib.append(fib[-1] + fib[-2])
    return fib

# Ejemplo de uso:
print(listar_fibonacci_20())
