import os
import time
import subprocess

# Путь к папке проекта
project_path = r"C:\OSPanelV6\home\desktopshop.local"

# Команды Git
def git_push():
    try:
        # Добавляем все файлы
        subprocess.run(["git", "add", "."], cwd=project_path)
        # Делаем коммит
        subprocess.run(["git", "commit", "-m", "Автоматическая синхронизация"], cwd=project_path)
        # Отправляем изменения на GitHub
        subprocess.run(["git", "push", "origin", "main"], cwd=project_path)
        print("Изменения успешно отправлены на GitHub!")
    except Exception as e:
        print(f"Ошибка при синхронизации: {e}")

# Отслеживание изменений
last_modified = 0
while True:
    try:
        # Получаем время последнего изменения файлов в папке
        current_modified = max(
            os.path.getmtime(os.path.join(project_path, f))
            for f in os.listdir(project_path)
            if os.path.isfile(os.path.join(project_path, f))
        )
    except ValueError:
        current_modified = 0  # Если папка пустая

    if current_modified > last_modified:
        print("Обнаружены изменения. Синхронизация с GitHub...")
        git_push()
        last_modified = current_modified

    # Проверяем каждые 5 секунд
    time.sleep(5)